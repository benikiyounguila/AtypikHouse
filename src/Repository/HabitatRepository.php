<?php

namespace App\Repository;

use App\Entity\Habitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Habitat>
 *
 * @method Habitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habitat[]    findAll()
 * @method Habitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habitat::class);
    }

    public function paginateHabitat(int $page, int $limit):Paginator
    {

        return new Paginator($this
        ->createQueryBuilder('h')
        ->setFirstResult(($page - 1) * $limit)
        ->setMaxResults($limit)
        ->getQuery()
        ->setHint(Paginator::HINT_ENABLE_DISTINCT,false),
        false);

    }

    public function findTotalPrice():int
    {
        return $this->createQueryBuilder('p')
        ->select('SUM(p.price) as total')
        ->getQuery()
        ->getSingleScalarResult();
    }

     /**
      * @return Habitat[] 
      */
    public function findWithPriceLowerThan(int $price): array
    {
        return $this->createQueryBuilder('h')
        ->select('h','c')
        ->where('h.price < :price')
        ->leftJoin('h.category', 'c')
        ->orderBy('h.price', 'ASC')
        //->andWhere('c.id = 1')
        ->setMaxResults(100)
        ->setParameter('price',$price)
        ->getQuery()
        ->getResult();
    }



    //    /**
    //     * @return Habitat[] Returns an array of Habitat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Habitat
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
