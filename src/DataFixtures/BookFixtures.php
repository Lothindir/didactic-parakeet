<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_CH');

        for ($i = 0; $i < 50; $i++) {
            $book = new Book();
            $book->setTitle($faker->catchPhrase);
            $book->setAuthorFirstName($faker->firstName());
            $book->setAuthorLastName($faker->lastName);
            $book->setSummary($faker->paragraphs(3, true));
            $book->setEditor($faker->company);
            $book->setReleaseDate($faker->dateTimeBetween('-100 years', '-5 years'));
            $book->setExtractLink($faker->url);
            $book->setCoverImage($faker->imageUrl(480,640));
            $cat = $this->getReference('Cat'.rand(0,4));
            $book->setCategory($cat);
            $user = $this->getReference('User'.rand(0,19));
            $book->setUser($user);

            $manager->persist($book);

            $this->addReference('Book'.$i, $book);
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
