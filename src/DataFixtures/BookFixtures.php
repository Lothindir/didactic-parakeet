<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $book = new Book();
            $book->setTitle('Title'.$i);
            $book->setAuthorFirstName('Author'.$i);
            $book->setAuthorLastName('Author'.$i);
            $book->setSummary('BIG SUMMARY '.$i);
            $book->setEditor('Editor'.$i);
            $book->setReleaseDate(new \DateTime());
            $book->setExtractLink('Link'.$i.'-'.$i);
            $book->setCoverImage('IMG'.$i);
            $cat = $this->getReference("Category".rand(0,4));
            $book->setCategory($cat);
            $user = $this->getReference('User'.rand(0,19));
            $book->setUser($user);

            $manager->persist($book);

            $this->addReference($book->getTitle(), $book);
        }

        $manager->flush();
    }

    

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            UserFixtures::class
        );
    }
}
