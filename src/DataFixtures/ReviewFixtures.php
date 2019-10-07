<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reviewsDone = [];

        for ($i = 0; $i < 1000; $i++) {
            $review = new Review();
            $user = new User();
            $book = new Book();

            do{
                $user = $this->getReference('User'.rand(0,19));
                $book = $this->getReference('Book'.rand(0,49));
            }while(count(array_filter($reviewsDone, function($v) use($book, $user)
            {
                return $v->getBook()->getId() == $book->getId() && 
                       $v->getUser()->getId() == $user->getId();
            })) !== 0);

            $user->addReview($review);
            $book->addReview($review);
            $review->setRating(rand(2.5,5));

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
