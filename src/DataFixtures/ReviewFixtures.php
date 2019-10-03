<?php

namespace App\DataFixtures;

use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reviewsDone = [];

        for ($i = 0; $i < 100; $i++) {
            $review = new Review();

            do{
                $review->setUser($this->getReference('User'.rand(0,19)));
                $review->setBook($this->getReference('Book'.rand(0,49)));
            }while(count(array_filter($reviewsDone, function($v) use($review)
            {
                return $v->getBook()->getId() == $review->getBook()->getId() && 
                       $v->getUser()->getId() == $review->getUser()->getId();
            })) !== 0);

            $review->setRating(rand(1,5));

            $reviewsDone[] = $review;
            $manager->persist($review);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            BookFixtures::class
        );
    }
}
