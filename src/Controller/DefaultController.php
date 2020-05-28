<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\User;

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

    /**
     * {@inheritdoc}
     */
    public function updateToken($existingToken, $newToken)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['authToken' => $existingToken]);

        $res = ($user === null) ? ['Created'] : ['Updated'];
        if (!$user) {
            $user = new User();
            $user->setUsername($newToken);
            $user->setPassword($newToken);
        }
        $user->setAuthToken($newToken);

        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse($res);
    }
}
