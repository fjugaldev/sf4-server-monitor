<?php

namespace App\Repository;

use App\Entity\ResponseCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResponseCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseCode[]    findAll()
 * @method ResponseCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResponseCode::class);
    }

//    /**
//     * @return ResponseCode[] Returns an array of ResponseCode objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponseCode
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
