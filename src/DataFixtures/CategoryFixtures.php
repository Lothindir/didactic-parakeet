<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = 'categories';

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $cat = new Category();
            $cat->setName('Category'.$i);
            $manager->persist($cat);

            $this->addReference($cat->getName(), $cat);
        }

        $manager->flush();
    }
}