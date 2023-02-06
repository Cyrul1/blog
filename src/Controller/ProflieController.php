<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProflieController extends AbstractController
{
    #[Route('/proflie/{id}', name: 'app_proflie')]
    public function show(User $user): Response
    {
        return $this->render('proflie/showProfile.html.twig', [
            'user'=> $user
        ]);
    }

    #[Route('/proflie/{id}/follows', name: 'app_proflie_follows')]
    public function follows(User $user): Response
    {
        return $this->render('follow/_follows.html.twig', [
            'user'=> $user
        ]);
    }

    #[Route('/proflie/{id}/followers', name: 'app_proflie_followers')]
    public function followers(User $user): Response
    {
        return $this->render('follow/_followers.html.twig', [
            'user'=> $user
        ]);
    }

}
