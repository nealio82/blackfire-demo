<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Kitty;
use Doctrine\ORM\EntityRepository;

class BreedRepository extends EntityRepository
{

    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function countBreeds()
    {
        $query = $this->createQueryBuilder('b')
            ->select('count(b.id) AS breedcount')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countKittiesBelongingToBreed($breed_name)
    {

        $query = $this->createQueryBuilder('b')
            ->select('count(k.id) AS kittycount')
            ->innerJoin('b.kitties', 'k')
            ->where('b.name = :breed')
            ->setParameter('breed', $breed_name)
            ->getQuery();

        return $query->getSingleScalarResult();

    }

}