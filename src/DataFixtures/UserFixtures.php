<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 3; $i++) { 
            $user = new User();
            $user->setEmail('johnDoe'. $i .'@email.fr');
            $user->setPassword($this->encoder->encodePassword($user, "password" . $i));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
