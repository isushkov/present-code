<?php

namespace App\Repository;

use App\Entity\DailyNeed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DailyNeed|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyNeed|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyNeed[]    findAll()
 * @method DailyNeed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyNeedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DailyNeed::class);
    }

    // /**
    //  * @return DailyNeed[] Returns an array of DailyNeed objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DailyNeed
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
