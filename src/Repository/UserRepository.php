<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getTotalReviewsDone($User)
    {
        $qb = $this->createQueryBuilder('u');

        return $qb->add('select', $qb->expr()->count('r.Rating'))
            ->from('App\Entity\Review', 'r')
            ->where('r.User = :id')
            ->setParameter('id', $User)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function getTotalBooksProposed($User)
    {
        $qb = $this->createQueryBuilder('u');

        return $qb->add('select', $qb->expr()->count('b.id'))
            ->from('App\Entity\Book', 'b')
            ->where('b.User = :id')
            ->setParameter('id', $User)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
