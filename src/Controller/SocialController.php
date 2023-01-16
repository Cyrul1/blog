<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle\ServiceEntityRepository;

class SocialController extends AbstractController
{
    #[Route('/social', name: 'app_social')]
    public function index(MicroPostRepository $posts): Response
    {

        return $this->render('social/indexx.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }
    #[Route('/social/{post}', name: 'app_social_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('social/show.html.twig', [
            'post' => $post,
        ]);
    }
    #[Route('/social/add', name: 'app_social_add', priority:2 )]
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            $post->setCreated(new DateTime());
            $posts->save($post, true);

            $this->addFlash('success', 'Twój post został dodany!');
            
            return $this-> redirectToRoute('app_social');
        }

        return $this->renderForm(
            'social/add.html.twig',
            [
                'form' => $form
            ]
            );  
    }

    #[Route('/social/{post}/edit', name: 'app_social_edit')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response
    {
        
        $form = $this->createForm(MicroPostType::class, $post);
        

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            
            $posts->save($post, true);

            $this->addFlash('success', 'Twój post został zaktualizownay!');
            
            return $this-> redirectToRoute('app_social');
        }

        return $this->renderForm(
            'social/edit.html.twig',
            [
                'form' => $form
            ]
            );  
    }

}
?>