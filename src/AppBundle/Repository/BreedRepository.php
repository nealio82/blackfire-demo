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

    public function countKittiesBelongingToBreed($breed_name)
    {

        $kitties = $this->getEntityManager()->getRepository(Kitty::class)->findAll();

        $tmp = [];

        foreach ($kitties AS $kitty) {

            if ($kitty->getBreed()->getName() == $breed_name) {
                $tmp[] = $kitty;
            }

        }

        return count($tmp);

    }

}