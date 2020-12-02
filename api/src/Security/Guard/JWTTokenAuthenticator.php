<?php

namespace App\Security\Guard;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTTokenAuthenticator extends BaseAuthenticator
{
    // Your own logic
    // public function checkCredentials($credentials, UserInterface $user)
    // {
    //     return true;
    // }

    // protected function loadUser(UserProviderInterface $userProvider, array $payload, $identity)
    // {
    //     if ($userProvider instanceof UserProvider) {
    //         return $userProvider->loadUserByUsername($identity, $payload);
    //     }
    //     return $userProvider->loadUserByUsername($identity);
    // }
}
