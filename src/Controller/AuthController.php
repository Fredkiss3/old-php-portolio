<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="auth.login")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        return $this->render('auth/login.html.twig', [
            'username' => $utils->getLastUsername(),
            'error' => $utils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="auth.logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This code should not be reached');
    }
}
