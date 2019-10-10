<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Review;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $usersRepository = $this->getDoctrine()->getRepository(User::class);
        $users = $usersRepository->findAll();

        /*echo '<p><ul>';
        foreach ($users as $user) {
            echo '<li>' . $user->getName() . " " . $usersRepository->getTotalBooksProposed($user) . " " . $usersRepository->getTotalReviewsDone($user) .'</li>' . "\r\n";
        }
        echo '</ul></p>';*/

        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->getLastAdded(5);

        /*foreach ($books as $book) {
            echo $this->getDoctrine()->getRepository(Book::class)->getAverageRating($book) . "\r\n";
        }
        dump($books);
        die();*/

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'users' => $users,
            'books' => $books
         ]);
    }
}
