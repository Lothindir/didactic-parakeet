<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Entity\User;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findByBook(Book $book)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Book = :val')
            ->setParameter('val', $book)
            ->orderBy('r.Rating', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByBookAndUser(Book $book, User $user)
    {
        return $this->createQueryBuilder('r')
            ->select('r.Rating')
            ->where('r.Book = :book')
            ->andWhere('r.User = :user')
            ->setParameter('book', $book)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAverageRatingByBook($book) {
        return $this->createQueryBuilder('r')
            ->select('avg(r.Rating)')
            ->where('r.Book = :id')
            ->setParameter('id', $book->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function getNumberOfReviewsByBook($book) {
        return $this->createQueryBuilder('r')
            ->select('count(r.Rating)')
            ->where('r.Book = :id')
            ->setParameter('id', $book->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
