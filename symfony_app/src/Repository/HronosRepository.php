<?php

namespace App\Repository;

use App\Entity\Hronos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hronos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hronos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hronos[]    findAll()
 * @method Hronos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HronosRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hronos::class);
    }

    // /**
    //  * @return Hronos[] Returns an array of Hronos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hronos
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
