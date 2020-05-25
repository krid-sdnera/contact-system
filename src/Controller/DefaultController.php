<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function index()
    {
        $message = "Hello.";
        return new Response($message);
    }
}
