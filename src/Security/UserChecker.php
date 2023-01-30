<?php
namespace App\Security;

use DateTime;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @param User $user
     */
    public function checkPreAuth(UserInterface $user)
    {
        if(null=== $user->getBannedUntil()){
        return;}
    
        $now = new DateTime();

        if($now < $user->getBannedUntil()){
            throw new AccessDeniedException('Użytkownik jest zbanowany');
        }
    }
    /**
     * @param User $user
     */
    public function checkPostAuth(UserInterface $user)
    {

    }

}