<?php

namespace App\Repository;

use App\Entity\ClassName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClassName|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassName|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassName[]    findAll()
 * @method ClassName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassName::class);
    }

    // /**
    //  * @return ClassName[] Returns an array of ClassName objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClassName
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
