<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = 'categories';

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $faker = Faker\Factory::create('fr_CH');

            $cat = new Category();
            $cat->setName($faker->sentence(3));
            $manager->persist($cat);

            $this->addReference('Cat'.$i, $cat);
        }

        $manager->flush();
    }
}