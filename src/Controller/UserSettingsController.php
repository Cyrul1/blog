<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\ProfileImgType;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UserSettingsController extends AbstractController
{
    #[Route('/user/settings', name: 'app_user_settings')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(Request $request, UserRepository $users): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userProfile = $user->getUserProfile() ?? new UserProfile();

        $form = $this->createForm(
            UserProfileType::class, $userProfile
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userProfile = $form->getData();
            $user->setUserProfile($userProfile);
            $users->save($user, true);
            $this->addFlash(
                'success',
                'Twoje ustawienia zostały zmienione'
            );
            return $this->redirectToRoute('app_user_settings');
        }

        return $this->render('user_settings/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/settings-img', name: 'app_user_settings_img')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profileImg(
        Request $request,
        SluggerInterface $slugger,
        UserRepository $users
    ): Response
    {
        $form = $this->createForm(ProfileImgType::class);
        /** @var user $user */
        $user = $this->getUser();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $profileImgFile = $form->get('profileImg')->getData();

            if ($profileImgFile){
                $orginalFileName = pathinfo(
                    $profileImgFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFileName = $slugger->slug($orginalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' . $profileImgFile->guessExtension();

                try{
                    $profileImgFile->move(
                        $this->getParameter('profiles_directory'),
                        $newFileName
                    );

                }catch(FileException $e){
                }

                $profile = $user->getUserProfile() ?? new UserProfile();
                $profile->setImage($newFileName);
                $user->setUserProfile($profile);
                $users->save($user, true);
                $this->addFlash('success', 'Twoje zdjęcie zostało zmienione.');

                return $this->redirectToRoute('app_user_settings_img');
            }

        }



        return $this->render('user_settings/profile_img.html.twig', [
            'form'=> $form->createView(),
       ]);        
    }
}
