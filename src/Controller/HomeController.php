<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->getLastReleased();

        foreach ($books as $key => $book) {
            dump($this->getDoctrine()
                    ->getRepository(Book::class)
                    ->getAllReviews($book)
                );
        }
        dump($books);
        die();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
