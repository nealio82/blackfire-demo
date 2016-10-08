<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class KittyRepository extends EntityRepository
{

    public function findAll()
    {
        return $this->findBy(array(), array('birthday' => 'ASC'));
    }

    public function paginate($page = 1, $limit = 100)
    {

        $query = $this->createQueryBuilder('k')
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        $paginator = new Paginator($query);

        return $paginator;

    }

}