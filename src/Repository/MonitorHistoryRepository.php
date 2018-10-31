<?php

namespace App\Repository;

use App\Entity\MonitorHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MonitorHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonitorHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonitorHistory[]    findAll()
 * @method MonitorHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonitorHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MonitorHistory::class);
    }

    public function getLastMonitorHistory($serverId)
    {
        /*dump($this->createQueryBuilder('m')
            ->andWhere('m.server = :serverId')
            ->setParameter('serverId', $serverId)
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSQL()); die();*/
        return $this->createQueryBuilder('m')
            ->andWhere('m.server = :serverId')
            ->setParameter('serverId', $serverId)
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
            ;
    }

    public function getTodayMonitorHistory($serverId)
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.serverStatus) as ss')
            ->andWhere('m.server = :serverId')
            ->groupBy('m.serverStatus')
            ->setParameter('serverId', $serverId)
            ->getQuery()
            ->getResult();
            ;
    }

//    /**
//     * @return ServerStatusHistory[] Returns an array of ServerStatusHistory objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServerStatusHistory
    {
        return $this->createQueryBuilder('m')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
