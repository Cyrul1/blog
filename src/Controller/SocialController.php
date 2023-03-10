<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle\ServiceEntityRepository;


class SocialController extends AbstractController
{
    #[Route('/social', name: 'app_social')]
    public function index(MicroPostRepository $posts): Response
    {

        return $this->render('social/indexx.html.twig', [
            'posts' => $posts->findAllWithComments(),
        ]);
    }

    #[Route('/social/topLiked', name: 'app_social_topLiked')]
    public function topLiked(MicroPostRepository $posts): Response
    {

        return $this->render('social/top_liked.html.twig', [
            'posts' => $posts->findAllWithMinLikes(1),
        ]);
    }
    
    #[Route('/social/follows', name: 'app_social_follows')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function follows(MicroPostRepository $posts): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        return $this->render('social/follows.html.twig', 
        [
            'posts' => $posts->findAllByAuthors(
                $currentUser->getFollows()
            ),
        ]);
    }    

    #[Route('/social/{post}', name: 'app_social_show')]
    #[IsGranted(MicroPost::VIEW, 'post')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('social/show.html.twig', [
            'post' => $post,
        ]);
    }
    #[Route('/social/add', name: 'app_social_add', priority:2 )]
    #[IsGranted('ROLE_VERIFIED')]
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            $post->setAuthor($this->getUser());
            $posts->save($post, true);

            $this->addFlash('success', 'Tw??j post zosta?? dodany!');
            
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
    #[IsGranted(MicroPost::EDIT, 'post')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response
    {
        
        $form = $this->createForm(MicroPostType::class, $post);
        

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            
            $posts->save($post, true);

            $this->addFlash('success', 'Tw??j post zosta?? zaktualizownay!');
            
            return $this-> redirectToRoute('app_social');
        }

        return $this->renderForm(
            'social/edit.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
            );  
    }

    #[Route('/social/{post}/comment', name: 'app_social_comment')]
    #[IsGranted('ROLE_COMMENTER')]
    public function addComment(MicroPost $post, Request $request, CommentRepository $comments): Response
    {
        
        $form = $this->createForm(CommentType::class, new Comment());
        

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $comments->save($comment, true);

            $this->addFlash('success', 'Tw??j komentarz zosta?? zaktualizownay!');
            
            return $this-> redirectToRoute('app_social_show',
         ['post' => $post->getId()]
        ); 
        }

        return $this->renderForm(
            'social/comment.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
            );  
    }

    

}
?>