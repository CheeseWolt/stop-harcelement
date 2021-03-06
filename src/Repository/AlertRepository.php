<?php

namespace App\Repository;

use App\Entity\Alert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Alert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alert[]    findAll()
 * @method Alert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alert::class);
    }

    public function getStatusRatioByMonth()
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT alert.status_id as idAlert, count(alert.status_id) as nb, 
        Substring(alert.event_date, 6, 2) as mois FROM `alert` 
        Group BY mois, idAlert ';
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll() ??null;
    }

    // GRAPH 2 Type d'Aggression / Mois


    // GRAPH 3 Victime genre / type d'aggression
    public function getVictimGenreByAlertType() 
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT sex.name as sexe, alert_style.name as typeAlert, count(alert.status_id) as nbAlert 
                FROM `sex` 
                JOIN user ON sex.id = user.sex_id 
                JOIN alert ON user.id = alert.alert_sender_id 
                JOIN status ON alert.status_id = status.id 
                JOIN alert_alert_style ON alert.id = alert_alert_style.alert_id 
                JOIN alert_style ON alert_alert_style.alert_style_id = alert_style.id 
                Group BY sexe, typeAlert';
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll() ??null;
    }

    //GRAPH 4 : Tranches horaires
    public function getHour() 
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT HOUR(alert.event_time) as heure, COUNT(alert.id) as nbAlert FROM alert GROUP BY heure ';
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll() ??null;
    }

    // GRAPH 5 : Localistation des incidents
    public function getPlace()
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT location.name as lieu, COUNT(alert.id) as nbAlert FROM alert JOIN location on alert.location_id = location.id GROUP BY lieu';
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll() ??null;
    }
    


    public function getActivAlertByUser($user)
    {
        $alerts = [];
        $em = $this->getEntityManager();
        $sql = 'SELECT * FROM `alert` WHERE `end_support_date` IS null AND alert_sender_id = ' . $user->getId();
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $alertsBdd = $stmt->fetchAll();
        foreach($alertsBdd as $element)
        {
            $alert = $this->findBy(['id'=>$element['id']]);
            $alerts[] = $alert[0];
        }
        return $alerts ?? null;
    }
    

    public function getClosedAlertsByUser($user)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT * FROM `alert` WHERE `end_support_date` IS NOT null AND alert_sender_id = " . $user->getId();
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $alertsBdd = $stmt->fetchAll();
        foreach($alertsBdd as $element)
        {
            $alert = $this->findBy(['id'=>$element['id']]);
            $alerts[] = $alert[0];
        }
        return $alerts ?? null;
    }

    public function getAlertToManage()
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT * FROM `alert` WHERE `alert_manager_id` IS null ';
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $alertsBdd = $stmt->fetchAll();
        foreach($alertsBdd as $element)
        {
            $alert = $this->findBy(['id'=>$element['id']]);
            $alerts[] = $alert[0];
        }
        return $alerts ?? null;
    }

    public function getClosedAlertManagedByUser($user)
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT * FROM `alert` WHERE `end_support_date` IS NOT null AND `alert_manager_id`= ' . $user->getId();
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $alertsBdd = $stmt->fetchAll();
        foreach($alertsBdd as $element)
        {
            $alert = $this->findBy(['id'=>$element['id']]);
            $alerts[] = $alert[0];
        }
        return $alerts ?? null;
    }

    public function getAlertsManaged($user)
    {
        $em = $this->getEntityManager();
        $sql = 'SELECT * FROM `alert` WHERE `end_support_date` IS null AND alert_manager_id = ' . $user->getId();
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $alertsBdd = $stmt->fetchAll();
        foreach($alertsBdd as $element)
        {
            $alert = $this->findBy(['id'=>$element['id']]);
            $alerts[] = $alert[0];
        }
        return $alerts ?? null;
    }



    // /**
    //  * @return Alert[] Returns an array of Alert objects
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
    public function findOneBySomeField($value): ?Alert
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
