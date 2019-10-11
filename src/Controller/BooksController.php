<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Integer;
use Proxies\__CG__\App\Entity\Book;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    /**
     * @Route("/books", name="books")
     */
    public function listAllBooks()
    {
        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function listAllCategories()
    {
        return $this->render('books/categories.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }

    /**
     * @Route("/categories/{category}", name="category")
     */
    public function listAllCategories(String $category)
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);

        return $this->render('books/categories.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }

    /**
     * @Route("/book/{id}", name="book")
     */
    public function showBook(int $id)
    {
        $booksRepository = $this->getDoctrine()->getRepository(Book::class);

        $book = $booksRepository->find($id);

        if($book === null) {
            throw $this->createNotFoundException('Ce livre n\'existe pas');
        }

        return $this->render('books/book.html.twig', [
            'controller_name' => 'BooksController',
            'book' => $book,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addBook()
    {
        return $this->render('books/add.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }
}
