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

//GRAPH 7 : Activité des profs sur le mois en cours
public function getRatioProfResponse()
{
    $em = $this->getEntityManager();
    $sql = 'SELECT user.user_name as Nom, substring(alert.event_date, 6, 2) as Mois, 
    COUNT(alert.id) as nbAlert FROM user JOIN alert ON user.id = alert.alert_manager_id 
    WHERE MONTH(alert.event_date) = MONTH(NOW()) GROUP BY Nom, Mois';
    $conn = $em->getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll() ??null;
}

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
