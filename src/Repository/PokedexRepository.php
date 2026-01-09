<?php

namespace App\Repository;

use App\Entity\Pokedex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokedex>
 */
class PokedexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokedex::class);
    }


    public function save(Pokedex $pokedex): void
    {
        $this->getEntityManager()->persist($pokedex);
        $this->getEntityManager()->flush();
    }
}
