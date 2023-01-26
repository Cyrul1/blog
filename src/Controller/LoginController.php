<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(
        AuthenticationUtils $untils
    ): Response
    {
        $lastusername = $untils->getLastUsername();
        $error = $untils->getLastAuthenticationError();

        return $this->render('login/index.html.twig', [
            'lastUsername' => $lastusername,
            'error'=> $error
        ]);
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        
    }
}
