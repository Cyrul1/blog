<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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
