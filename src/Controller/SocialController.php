<?php

namespace App\Controller;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle\ServiceEntityRepository;
use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SocialController extends AbstractController
{
    #[Route('/social', name: 'app_social')]
    public function index(MicroPostRepository $posts): Response
    {
    //dd($posts->findAll());  
     /*   $microPost = new MicroPost();
        $microPost-> setTitle('it comes from controler');
        $microPost-> setText('to wychodzi z controlera');
      $microPost-> setCreated(new DateTime());
      /*
    #    $microPost = $posts->find(4);
        #$microPost->setTitle('Welcom in general');

        $posts->save($microPost, True);
       /* $microPost = $posts->find(4);
        $microPost->setTitle('Welcom in general');

        $em = $this->getDoctrine()->getManager();
        $em->persist($microPost);
        $em->flush();
        */
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
}
?>