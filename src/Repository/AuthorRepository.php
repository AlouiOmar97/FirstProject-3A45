<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

        /**
         * @return Author Returns an array of Author objects
         */
        public function findAuthorsByEmail($email): Author
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.email LIKE :email')
                ->setParameter('email', '%'.$email.'@gmail.com')
                ->orderBy('a.id', 'ASC')
                //->setMaxResults(1)
                ->getQuery()
                ->getSingleResult()
            ;
        }


        public function findAuthorsByNbBooks($nbBooks)
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.nbBooks < :nbBooks')
                ->setParameter('nbBooks', $nbBooks)
                ->orderBy('a.id', 'ASC')
                //->setMaxResults(1)
                ->getQuery()
                ->getSQL()
            ;
        }

        public function findNumberOfAuthorsByNbBooks($nbBooks)
        {
            return $this->createQueryBuilder('a')
                ->select('count(a.id)')
                ->andWhere('a.nbBooks < :nbBooks')
                ->setParameter('nbBooks', $nbBooks)
                ->orderBy('a.id', 'ASC')
                //->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
