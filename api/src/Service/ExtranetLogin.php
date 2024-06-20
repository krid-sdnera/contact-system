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


    public function __construct(Stopwatch $stopwatch, LoggerInterface $extranetLogger)
    {
        $this->stopwatch = $stopwatch;
        $this->logger = $extranetLogger;
    }

    public static function HttpClientFactory($cookie = ''): HttpClientInterface
    {
        return HttpClient::createForBaseUri('https://www.vicscouts.asn.au', [
            'headers' => [
                'Host' => 'www.vicscouts.asn.au',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Connection' => 'Keep-Alive',
                'Content-type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Cookie' => $cookie
            ],
        ]);
    }

    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;
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

        // Get cookie and regenerate Http Client
        $cookie = $loginResponse->getHeaders()['set-cookie'][0];
        $this->setClient(self::HttpClientFactory($cookie));

        $this->do2FANextStep($loginResponse);
        $this->do2FAActionValidate($loginResponse);
        $loginResponse = $this->do2FAConfirm($loginResponse);

        if ($this->isExtranetCensusActive($loginResponse)) {
            $this->checkExtranetLoginCensus();
        } else if ($this->isExtranetInsuranceActive($loginResponse)) {
            $this->checkExtranetLoginInsurance();
        } else if ($this->isExtranetPasswordExpiryActive($loginResponse)) {
            $this->checkExtranetLoginPasswordExpiry();
        } else {
            $this->checkExtranetLoginSuccessfull($loginResponse);
        }

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

        return $loginResponse;
    }

    private function isExtranetCensusActive(ResponseInterface $response): bool
    {
        $this->logger->info('Checking login for census');
        $content = $response->getContent();

        // Check for the existance of the census style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'(/portal/Interface/MSUCensus/CensusCount/pfcConfirmReport.php)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            $this->logger->info("Census not active");
            return false;
        }
        return true;
    }

    private function checkExtranetLoginCensus(): void
    {
        // Fetch Census Report page
        $censusResponse = $this->client->request('GET', '/portal/Interface/MSUCensus/CensusCount/pfcConfirmReport.php');

        // Check for the existance of the successful login style redirect after census.
        preg_match(
            '|window.location.replace\(\'\..\/..\/mainPage.php\?var=(\d+)\'\)|',
            $censusResponse->getContent(),
            $matches
        );

        if (count($matches) === 2) {
            // Login successful
            return;
        }

        // Check that there is a verify button
        preg_match(
            "|onclick=\"verify\(false,'(\d+)','(redirect)'\)\"|",
            $censusResponse->getContent(),
            $matches
        );

        if (count($matches) !== 3) {
            // There was no verify button
            throw new Exception('Census active: verify button not found.');
        }

        // Fetch Census confirm page
        $censusConfirmResponse = $this->client->request('GET', '/portal/Interface/MSUCensus/CensusCount/pfcConfirmAction.php', [
            'query' => [
                'groupID' => $matches[1],
                'pTarget' => $matches[2],
                'bConfirm' => 'N',
            ]
        ]);

        $this->logger->info('Checking login for success');
        $content = $censusConfirmResponse->getContent();

        // Check for the existance of the successful login style redirect after census.
        preg_match(
            '|window.location.replace\(\'\..\/..\/mainPage.php\?var=(\d+)\'\)|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to login
            throw new Exception('Unable to Login! Check the credentials: case census');
        }
    }

    private function isExtranetInsuranceActive(ResponseInterface $response): bool
    {
        $this->logger->info('Checking login for insurance');
        $content = $response->getContent();

        // Check for the existance of the insurance style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'(/portal/Controllers/controller_extranet\.php\?request\=Insurance\.Questionnaire\.Open\&FromLogin\=yes)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            $this->logger->info("Insurance not active");
            return false;
        }
        return true;
    }

    private function checkExtranetLoginInsurance(): void
    {
        // Fetch Insurance Questionnaire page
        $insuranceResponse = $this->client->request('GET', '/portal/Controllers/controller_extranet.php', [
            'query' => [
                'request' => 'Insurance.Questionnaire.Open',
                'FromLogin' => 'yes'
            ]
        ]);

        // Check that there is a verify button
        preg_match(
            "|(Proceed to Extranet)|",
            $insuranceResponse->getContent(),
            $matches
        );

        if (count($matches) !== 2) {
            // There was no verify button
            throw new Exception('Insurance active: verify button not found.');
        }
    }

    private function isExtranetPasswordExpiryActive(ResponseInterface $response): bool
    {
        $this->logger->info('Checking login for password expiry');
        $content = $response->getContent();

        // Check for the existance of the password expiry style redirect
        preg_match(
            '|<title> Password expire in \d+ days? <\/title>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Password has not expired
            return false;
        }
        return true;
    }

    private function checkExtranetLoginPasswordExpiry(): void
    {
        // Set active module to the change password interface
        $this->client->request('POST', '/portal/Interface/mainPage.php', [
            'body' => [
                'mainWindow' => '/Module1/memberModifyPasswordInterface.php'
            ]
        ]);

        // Change password to the existing password
        $passwordChangeResponse = $this->client->request('POST', '/portal/Interface/mainPage.php', [
            'body' => [
                'cPass' => $this->credentials['password'],
                'newPass1' => $this->credentials['password'],
                'newPass2' => $this->credentials['password'],
                'submitPass' => 'Save'
            ]
        ]);

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

        preg_match(
            '|window\.location\.replace\(\'/portal/Interface/mainPage\.php\?var=(\d+)\'\)|',
            $passwordChangeResponse->getContent(),
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to login
            throw new Exception('Unable to Login! Check the credentials: case pwd');
        }
    }

    private function checkExtranetLoginSuccessfull(ResponseInterface $response): void
    {
        $this->logger->info('Checking login for success');
        $content = $response->getContent();

        // Check for the existance of the successful login style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'/portal/Interface/mainPage.php\?var=(\d+)\'\);">|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to login
            throw new Exception('Unable to Login! Check the credentials: case basic');
        }
    }

}
