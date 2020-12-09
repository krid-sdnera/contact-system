<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function index()
    {
        $message = ["message" => "Hello. I don't think you're meant to be here"];
        return new JsonResponse($message);
    }
}
