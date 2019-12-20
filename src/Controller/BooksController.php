<?php

namespace App\Controller;

use App\Form\AddBookType;
use Proxies\__CG__\App\Entity\Book;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        if ($cat === null) {
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

        if ($book === null) {
            throw $this->createNotFoundException('Ce livre n\'existe pas');
        }

        return $this->render('books/book.html.twig', [
            'controller_name' => 'BooksController',
            'book' => $book,
            'bookCoverIsURL' => $this->isUrl($book->getCoverImage())
        ]);
    }

    /**
     * @Route("/add", name="add")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function addBook(Request $request): Response
    {
        $book = new Book();

        $form = $this->createForm(AddBookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setTitle($form->get('Title')->getData());
            $book->setExtractLink($form->get('ExtractLink')->getData());
            $book->setSummary($form->get('Summary')->getData());
            $book->setAuthorLastName($form->get('AuthorLastName')->getData());
            $book->setAuthorFirstName($form->get('AuthorFirstName')->getData());
            $book->setEditor($form->get('Editor')->getData());
            $book->setNumberPages($form->get('NumberPages')->getData());
            $book->setReleaseDate($form->get('ReleaseDate')->getData());

            $imagePath = '';
            if ($form->get('CoverImage')->get('CoverImageFile')->getData() !== null) {
                $image = $form->get('CoverImage')->get('CoverImageFile')->getData();
                $filename = filter_var(preg_replace('/\s+/', '', $form->get('Title')->getData()),FILTER_SANITIZE_STRING);
                $image->move('uploads', $filename . '.png');
                $imagePath = '/uploads/' . $filename . '.png';
            }
            else if ($this->isUrl($form->get('CoverImage')->get('CoverImageURL')->getData())){
                $imagePath = $form->get('CoverImage')->get('CoverImageURL')->getData();
            }
            else { //The form is not valid
                return $this->render('books/add.html.twig', [
                    'controller_name' => 'BooksController',
                    'addBookForm' => $form->createView()
                ]);
            }

            $book->setCoverImage($imagePath);
            $book->setCategory($form->get('Category')->getData());
            $book->setAddedDate(new \DateTime());
            $book->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirect('/book/'.$book->getId());
        }

        return $this->render('books/add.html.twig', [
            'controller_name' => 'BooksController',
            'addBookForm' => $form->createView()
        ]);
    }

    private function isUrl($uri)
    {
        return preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $uri);
    }
}
