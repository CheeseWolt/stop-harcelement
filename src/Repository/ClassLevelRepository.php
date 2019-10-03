<?php

namespace App\Repository;

use App\Entity\ClassLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClassLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassLevel[]    findAll()
 * @method ClassLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassLevel::class);
    }

    //GRAPH 6 - nombre de Cas / Classe
    public function getRatioByClassLevel()
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT class_level.name as niveauScolaire, COUNT(alert.id) as nbAlert 
                FROM class_level 
                JOIN class_name ON class_level.id = class_name.class_level_id 
                JOIN user ON class_name.id = user.student_class_name_id 
                JOIN alert ON user.id = alert.alert_sender_id 
                GROUP BY niveauScolaire';
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll() ??null;
    }

    // /**
    //  * @return ClassLevel[] Returns an array of ClassLevel objects
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
    public function findOneBySomeField($value): ?ClassLevel
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
