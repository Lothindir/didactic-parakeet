<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {

            $faker = Faker\Factory::create('fr_CH');

            $user = new User();
            $user->setName($faker->userName);
            $user->setEntryDate($faker->dateTimeBetween('-15 years'));
            $user->setHashedPassword($faker->sha256);
            $manager->persist($user);

            $this->addReference('User'.$i, $user);
        }

        $manager->flush();
    }
}