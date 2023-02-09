<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProflieController extends AbstractController
{
    #[Route('/proflie/{id}', name: 'app_proflie')]
    public function show(
        User $user,
        MicroPostRepository $posts
        ): Response
    {
        return $this->render('proflie/showProfile.html.twig', [
            'user'=> $user,
            'posts'=>$posts->findAllByAuthor(
                $user
            )
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
