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
        $message = "Hello.";
        return new Response($message);
    }

    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        var_dump($request->request->get('_username'));
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
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
