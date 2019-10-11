<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $adminUser = new User();
        $adminUser->setUsername('admin');
        $adminUser->setEntryDate(new \DateTime());
        $adminUser->setPassword($this->passwordEncoder->encodePassword(
            $adminUser,
            'admin'
        ));
        $adminUser->setRoles(array_merge($adminUser->getRoles(), ['ROLE_ADMIN']));
        $manager->persist($adminUser);
        $this->addReference('ADMIN', $adminUser);

        for ($i = 0; $i < 20; $i++) {

            $faker = Faker\Factory::create('fr_CH');

            $user = new User();
            $user->setUsername($faker->userName);
            $user->setEntryDate($faker->dateTimeBetween('-15 years'));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                '1234'
            ));
            $manager->persist($user);

            $this->addReference('User'.$i, $user);
        }

        $manager->flush();
    }
}