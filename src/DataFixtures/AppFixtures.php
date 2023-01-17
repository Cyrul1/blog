<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('test@etest.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('test1@etest.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                '12345678'
            )
        );
        $manager->persist($user2);

        $micropost1 = new MicroPost();
        $micropost1-> setTitle('Welcome to Poland!');
        $micropost1-> setText('Witamy w Polsce!');
        $micropost1-> setCreated(new DateTime());

        $manager->persist($micropost1);

        $micropost2 = new MicroPost();
        $micropost2-> setTitle('Welcome to USA!');
        $micropost2-> setText('Witamy w USA!');
        $micropost2-> setCreated(new DateTime());

        $manager->persist($micropost2);

        $micropost3 = new MicroPost();
        $micropost3-> setTitle('Welcome to Germany!');
        $micropost3-> setText('Witamy w Niemczech!');
        $micropost3-> setCreated(new DateTime());

        $manager->persist($micropost3);

        $manager->flush();
    }
}
