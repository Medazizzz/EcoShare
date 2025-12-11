<?php

namespace App\Repository;

use App\Entity\SponsorPartenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SponsorPartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SponsorPartenaire::class);
    }


    /**
     * @return SponsorPartenaire[]
     */
    public function findFavorites(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.favori = :fav')
            ->setParameter('fav', true)
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
