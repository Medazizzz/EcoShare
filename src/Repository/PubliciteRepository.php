<?php

namespace App\Repository;

use App\Entity\Publicite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PubliciteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publicite::class);
    }


    /**
     * @return Publicite[]
     */
    public function findFavorites(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.favori = :fav')
            ->setParameter('fav', true)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
