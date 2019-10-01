<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setName('User'.$i);
            $user->setEntryDate(new \DateTime());
            $hashedPwd = password_hash($user->getName().$user->getEntryDate()->getTimestamp(), PASSWORD_BCRYPT);
            $user->setHashedPassword($hashedPwd);
            $manager->persist($user);

            $this->addReference($user->getName(), $user);
        }

        $manager->flush();
    }
}