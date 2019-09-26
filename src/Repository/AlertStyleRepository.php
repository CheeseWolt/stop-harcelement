<?php

namespace App\Repository;

use App\Entity\AlertStyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AlertStyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlertStyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlertStyle[]    findAll()
 * @method AlertStyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertStyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlertStyle::class);
    }

    public function getStylesByMonth()
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT alert_style.name as typeAlert, substring(alert.event_date,6,2) as month, COUNT(alert.id) as nbAlert
                FROM alert 
                JOIN alert_alert_style ON alert.id = alert_alert_style.alert_id 
                JOIN alert_style on alert_alert_style.alert_style_id = alert_style.id 
                GROUP BY month, typeAlert ';
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    // /**
    //  * @return AlertStyle[] Returns an array of AlertStyle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AlertStyle
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
