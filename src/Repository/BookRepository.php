<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getLastReleased(int $limit = 5)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.ReleaseDate', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getLastAdded(int $limit = 5)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.AddedDate', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getAverageRating($book)
    {
        $qb = $this->createQueryBuilder('b');
        return $qb
            ->add('select', $qb->expr()->avg('r.Rating'))
            ->from('App\Entity\Review', 'r')
            ->where('r.Book = :id')
            ->setParameter('id', $book->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function getNumberOfReviews($book)
    {
        $qb = $this->createQueryBuilder('b');
        return $qb
            ->select('count(r.Rating)')
            ->from('App\Entity\Review', 'r')
            ->where('r.Book = :id')
            ->setParameter('id', $book->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
