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
        $adminUser->setRoles(["ROLE_ADMIN"]);
        $manager->persist($adminUser);
        $this->addReference('ADMIN', $adminUser);

        $manager->flush();
    }
}