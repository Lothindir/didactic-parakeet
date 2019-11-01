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
        $categories = array('Science-Fiction', 'Fantasy', 'Policier', 'Amour', 'Thriller', 'Historique', 'Jeunesse', 'Théatre', 'BD', 'Manga', 'Biographie');

        for ($i = 0; $i < 11; $i++) {

            $cat = new Category();
            $cat->setName($categories[$i]);
            $manager->persist($cat);

            $this->addReference('Cat'.$i, $cat);
        }

        $manager->flush();
    }
}