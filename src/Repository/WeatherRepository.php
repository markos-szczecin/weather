<?php

namespace App\Repository;

use App\Entity\Weather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Weather|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weather|null findOneBy(array $criteria, array $orderBy = null)

 * @method Weather[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherRepository extends ServiceEntityRepository
{
    const DEFAULT_PER_PAGE = 30;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Weather::class);
    }

    public function findAll(int $hydration = AbstractQuery::HYDRATE_OBJECT)
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.id', 'DESC')
            ->getQuery()
            ->getResult($hydration);
    }

    public function getWithLimit($page, int $hydration = AbstractQuery::HYDRATE_OBJECT)
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.id', 'DESC')
            ->setMaxResults(self::DEFAULT_PER_PAGE)
            ->setFirstResult(($page - 1) * self::DEFAULT_PER_PAGE)
            ->getQuery()
            ->getResult($hydration);
    }

    // /**
    //  * @return Weather[] Returns an array of Weather objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Weather
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
