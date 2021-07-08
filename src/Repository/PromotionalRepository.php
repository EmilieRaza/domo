<?php

namespace App\Repository;

use App\Entity\Promotional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Promotional|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotional|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotional[]    findAll()
 * @method Promotional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Promotional::class);
    }

    // /**
    //  * @return Promotional[] Returns an array of Promotional objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Promotional
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
