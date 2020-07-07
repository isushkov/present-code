<?php

namespace App\Repository;

use App\Entity\RegTrans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RegTrans|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegTrans|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegTrans[]    findAll()
 * @method RegTrans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegTransRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RegTrans::class);
    }

    // /**
    //  * @return RegTrans[] Returns an array of RegTrans objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
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
    public function findOneBySomeField($value): ?RegTrans
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
