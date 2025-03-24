<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;

class ExtranetLogin
{

    /**
     * @var Stopwatch
     */
    private $stopwatch;
    /**
     * @var LoggerInterface
     */
    private $logger;

    private $credentials = [
        'username' => '',
        'password' => ''
    ];

    /**
     * @var HttpClientInterface
     */
    private $client;
    private $lastCookie = null;


    public function __construct(Stopwatch $stopwatch, LoggerInterface $extranetLogger)
    {
        $this->stopwatch = $stopwatch;
        $this->logger = $extranetLogger;
    }

    public static function HttpClientFactory($cookie = ''): HttpClientInterface
    {
        return HttpClient::createForBaseUri('https://extranet.scoutsvictoria.com.au', [
            'headers' => [
                'Host' => 'extranet.scoutsvictoria.com.au',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Connection' => 'Keep-Alive',
                'Content-type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:136.0) Gecko/20100101 Firefox/136.0',
                'Cookie' => $cookie
            ],
        ]);
    }

    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function updateCookie(ResponseInterface $response)
    {
        // Get cookie and regenerate Http Client
        $headers = $response->getHeaders();
        if (!array_key_exists('set-cookie', $headers)) {
            return;
        }

        $cookie = $headers['set-cookie'][0];

        if ($this->lastCookie !== $cookie) {
            $this->setClient(self::HttpClientFactory($cookie));
        }
    }

    public function setCredentials($username, $password): self
    {
        $this->credentials = [
            'username' => $username,
            'password' => $password
        ];
        return $this;
    }

    public function doExtranetLogin(): HttpClientInterface
    {
        $this->setClient(self::HttpClientFactory());


        $this->stopwatch->start('extranet-login');
        $this->logger->info('Doing login');
        $loginResponse = $this->client->request('POST', '/portal/loginCheck.php?var=', [
            'body' => [
                'username' => $this->credentials['username'],
                'password' => $this->credentials['password'],
                'form_submission' => ''
            ]
        ]);
        $this->updateCookie($loginResponse);

        $this->do2FANextStep($loginResponse);
        $this->do2FAActionValidate($loginResponse);
        $loginResponse = $this->do2FAConfirm($loginResponse);

        if ($this->isExtranetPasswordExpiryActive($loginResponse)) {
            $this->checkExtranetLoginPasswordExpiry();
        }

        $this->checkExtranetLoginSuccessfull();

        $this->logger->info('Logged in');
        $this->stopwatch->stop('extranet-login');
        $this->logger->debug(
            $this->loopLoggerHelper('extranet-login', 1)
        );

        return $this->client;
    }

    function loopLoggerHelper(string $eventName, int $entityCount, $options = [])
    {
        $event = $this->stopwatch->getEvent($eventName);
        if (isset($options['lap']) && $options['lap'] === true) {
            $period = $event->getPeriods()[count($event->getPeriods()) - 1];
            $lapMemory = $period->getMemory() / 1024 / 1024;
            $lapDuration = $period->getDuration();

            return sprintf(
                '[timings] %s entity index %d/%s%d, current: %.2F MiB - %d ms',
                $eventName,
                count($event->getPeriods()),
                (isset($options['approx']) && $options['approx'] === true) ? '~' : '',
                $entityCount,
                $lapMemory,
                $lapDuration
            );
        }

        $event = $this->stopwatch->getEvent($eventName);
        $memory = $event->getMemory() / 1024 / 1024;
        $duration = $event->getDuration();

        return sprintf(
            '[timings] %s entity count %d, average: %.2F MiB - %d ms total: %.2F MiB - %d ms',
            $eventName,
            $entityCount,
            $memory / $entityCount,
            $duration / $entityCount,
            $memory,
            $duration
        );
    }

    private function do2FANextStep(ResponseInterface $response): void
    {
        $this->logger->info('Checking 2FA next step');
        $content = $response->getContent();

        // Check that the 2FA next step is exposed.
        preg_match(
            '|<input type="hidden" name="nextAuthStep" id="nextAuthStep" value="1">|',
            $content,
            $matches
        );

        if (count($matches) !== 1) {
            $this->logger->info('Performing 2FA next step');

            $_2fa_next_step = $this->client->request(
                'POST',
                '/portal/twoFactorAuth.php',
                [
                    'body' => [
                        "username" => $this->credentials['username'],
                        "password" => $this->credentials['password'],
                        "nextAuthStep" => "1"
                    ]
                ]
            );
            $this->updateCookie($_2fa_next_step);

        }
    }

    private function do2FAActionValidate(ResponseInterface $response): void
    {
        $this->logger->info('Sending 2FA request');
        $_2fa_security_question = $this->client->request(
            'POST',
            '/portal/twoFactorAuth.php',
            [
                'body' => [
                    "username" => $this->credentials['username'],
                    "password" => $this->credentials['password'],
                    "authMethod" => "QUESTION",
                    "authFormAction" => "validate",
                    "questionID" => "3",
                    "answerInput" => "3040",
                    "btnSubmitQuestionAnswer" => "Submit"
                ]
            ]
        );
        $this->updateCookie($_2fa_security_question);

    }

    private function do2FAConfirm(ResponseInterface $response): ResponseInterface
    {
        $this->logger->info('Confirming 2FA request with extranet');
        $loginResponse = $this->client->request(
            'POST',
            '/portal/authNext.php',
            [
                'body' => [
                    "username" => $this->credentials['username'],
                    "authprocess" => "authNext"
                ]
            ]
        );
        $this->updateCookie($loginResponse);

        return $loginResponse;
    }

    private function isExtranetPasswordExpiryActive(ResponseInterface $response): bool
    {
        $this->logger->info('Checking login for password expiry');
        $content = $response->getContent();

        // Check for the existance of the password expiry style redirect
        preg_match(
            '|<title>.*Password expires? in \d+ days?.*<\/title>|',
            $content,
            $matches
        );

        if (count($matches) !== 1) {
            // Password has not expired
            return false;
        }
        return true;
    }

    private function checkExtranetLoginPasswordExpiry(): void
    {
        // Set active module to the change password interface
        $response = $this->client->request('POST', '/portal/Interface/mainPage.php', [
            'body' => [
                'mainWindow' => '/Module1/memberModifyPasswordInterface.php'
            ]
        ]);
        $this->updateCookie($response);

        // Change password to the existing password
        $passwordChangeResponse = $this->client->request('POST', '/portal/Interface/mainPage.php', [
            'body' => [
                'cPass' => $this->credentials['password'],
                'newPass1' => $this->credentials['password'],
                'newPass2' => $this->credentials['password'],
                'submitPass' => 'Save'
            ]
        ]);
        $this->updateCookie($passwordChangeResponse);

        // Check that the password was updated
        preg_match(
            "|Change of password succesful. Your password will expire in (\d+) days.|",
            $passwordChangeResponse->getContent(),
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to update password
            throw new Exception('Password expiring: cannot update password');
        }

        $this->logger->notice('Password updated successfully. Your password will expire in ' . $matches[1] . ' days.');
    }

    private function checkExtranetLoginSuccessfull(): void
    {
        $this->logger->info('Checking if login was successful');

        $mainPageResponse = $this->client->request('GET', '/portal/Interface/mainPage.php');

        $content = $mainPageResponse->getContent();

        // Check for the existance of the successful login style redirect
        preg_match(
            '|Last Login \d+.+ \w+ \d{4}|',
            $content,
            $matches
        );

        if (count($matches) !== 1) {
            $this->logger->notice($content);

            // Unable to login
            throw new Exception('Unable to Login! Check the credentials: case basic');
        }
    }

}
