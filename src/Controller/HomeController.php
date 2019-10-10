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

        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->getLastAdded(5);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'users' => $users,
            'books' => $books
         ]);
    }
}
