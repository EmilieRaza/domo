<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findBySimilar(array $datas, $id, $limit)
    {
        $query = $this->findVisibleQuery();

        foreach($datas as $key => $value){
            if($value){
                $query = $query
                    ->andWhere('p.'.$key.' = :'.$key)
                    ->setParameter($key, $value);
            }
        }

        if($id){
            $query = $query
                ->andWhere('p.id != :id')
                ->setParameter('id', $id);
        }

        $query = $query
            ->orderBy('p.updatedAt', 'DESC');
        
        $query = $query
            ->setMaxResults( $limit );
     

        return $query
                ->getQuery()
                ->getResult()
            ;
    }

    public function findVisibleQuery()
    {
        return $this->createQueryBuilder('p')
        ->where('p.isActive = 1');
    }

    public function isFlagship()
    {
        return $this->createQueryBuilder('p')
        ->where('p.isFlagship = 1')->getQuery()->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
