<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Reservation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @return Query retourne la requête pour toutes les réservations confirmées ou non
     */
    public function findAllResaQuery($confirm): Query
    {
        return $this->createQueryBuilder('r')
            ->where('r.confirm = :confirm')
            ->andWhere('r.date >= :today')
            ->setParameter('today',new \DateTime('today'))
            ->setParameter('confirm', $confirm)
            ->addOrderBy('r.date', 'ASC')
            ->addOrderBy('r.time', 'ASC')
            ->getQuery();
    }

    /**
     * @return Query retourne la requ$ete pour les réservations du jour confirmées au service du midi
     */
    public function findAllDayLunchConfirmQuery(): Query
    {
        $min = date('11:00');
        $max = date('16:00');
        return $this->createQueryBuilder('r')
            ->where('r.confirm = true')
            ->andWhere('r.date = :today')
            ->andwhere('r.time BETWEEN :min AND :max')
            ->setParameter('today',new \DateTime('today'))
            ->setParameter('min', $min) 
            ->setParameter('max', $max)  
            ->orderBy('r.time', 'ASC')
            ->getQuery();
    }

    /**
     * @return Query retourne la requête pour les réservations du jour confirmées au service du soir
     */
    public function findAllDayEveningConfirmQuery(): Query
    {
        $min = date('18:00');
        $max = date('23:00');
        return $this->createQueryBuilder('r')
            ->where('r.confirm = true')
            ->andWhere('r.date = :today')
            ->andwhere('r.time BETWEEN :min AND :max')
            ->setParameter('today',new \DateTime('today'))
            ->setParameter('min', $min) 
            ->setParameter('max', $max)  
            ->orderBy('r.time', 'ASC')
            ->getQuery();
    }

    /**
     * @return Query retourne la requête pour l'historique des réservations
     */
    public function findAllHistoryQuery(): Query
    {
        return $this->createQueryBuilder('r')
            ->where('r.date < :today')
            ->setParameter('today',new \DateTime('today'))
            ->orderBy('r.date', 'DESC')
            ->getQuery();
    }    
}
