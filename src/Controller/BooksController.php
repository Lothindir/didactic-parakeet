<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Integer;
use Proxies\__CG__\App\Entity\Book;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BooksController extends AbstractController
{
    /**
     * @Route("/books", name="books")
     */
    public function listAllBooks()
    {
        $booksRepository = $this->getDoctrine()->getRepository(Book::class);

        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
            'title' => 'Tous les livres',
            'books' => $booksRepository->findBy(array(), array('Title' => 'ASC'))
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function listAllCategories()
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);

        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
            'title' => 'Toutes les catégories',
            'categories' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/categories/{category}", name="category")
     */
    public function listBooksByCategory(String $category)
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);

        $cat = $categoryRepository->findOneBy(array('Name' => $category));

        if($cat === null) {
            throw $this->createNotFoundException('Cette catégorie n\'existe pas');
        }

        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
            'title' => 'Catégorie ' . $cat->getName(),
            'books' => $cat->getBooks()
        ]);
    }

    /**
     * @Route("/book/{id}", name="book")
     * 
     * @IsGranted("ROLE_USER")
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
     * 
     * @IsGranted("ROLE_USER")
     */
    public function addBook()
    {
        return $this->render('books/add.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }
}
