<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\ReviewRepository;
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
        $reviewRepository = $this->getDoctrine()->getRepository(Review::class);

        $book = $booksRepository->find($id);

        if ($book === null) {
            throw $this->createNotFoundException('Ce livre n\'existe pas');
        }

        $userReview = $reviewRepository->findByBookAndUser($book, $this->getUser());

        return $this->render('books/book.html.twig', [
            'controller_name' => 'BooksController',
            'book' => $book,
            'user' => $this->getUser(),
            'bookCoverIsURL' => $this->isUrl($book->getCoverImage()),
            'bookAvgRating' => number_format((float)$reviewRepository->getAverageRatingByBook($book), 2, ',', ''),
            'bookNbReviews' => $reviewRepository->getNumberOfReviewsByBook($book),
            'userReview' => empty($userReview) ? 0 : $userReview[0]['Rating'],
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
                $imagePath = '/public/uploads/' . $filename . '.png';
                $img = $this->resize_image($imagePath, 600, 450, true);
                $img->move('uploads', $filename . '.png');
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

            return $this->redirect('/book/'.$book->getId());
        }

        return $this->render('books/add.html.twig', [
            'controller_name' => 'BooksController',
            'addBookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/book/{id}/review", name="addReview")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function addReview(int $id)
    {
        if(!isset($_POST['rating']) || (float)($_POST['rating'] * 2) % 1 !== 0 || $_POST['rating'] < 0.5 || $_POST['rating'] > 5) {
            return $this->redirect('/book/' . $id);
        }

        $booksRepository = $this->getDoctrine()->getRepository(Book::class);
        $book = $booksRepository->find($id);

        if ($book === null) {
            throw $this->createNotFoundException('Ce livre n\'existe pas');
        }

        $review = new Review();
        $this->getUser()->addReview($review);
        $book->addReview($review);
        $review->setRating($_POST['rating']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($review);
        $entityManager->flush();

        return $this->redirect('/book/' . $id);
    }

    /**
     * @Route("/book/{id}/remove", name="remove")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function removeBook(int $id)
    {
        $booksRepository = $this->getDoctrine()->getRepository(Book::class);
        $book = $booksRepository->find($id);

        if ($book === null) {
            throw $this->createNotFoundException('Ce livre n\'existe pas');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $reviews = $this->getDoctrine()->getRepository(Review::class)->findByBook($book);
        foreach ($reviews as $rId => $review) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    private function isUrl($uri)
    {
        return preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $uri);
    }

    private function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        return $dst;
    }
}
