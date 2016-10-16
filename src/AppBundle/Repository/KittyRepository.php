<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class KittyRepository extends EntityRepository
{

    public function findAll()
    {
        return $this->findBy(array(), array('birthday' => 'ASC'));
    }

    public function countKitties()
    {
        $query = $this->createQueryBuilder('k')
            ->select('count(k.id) AS kittycount')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function paginate($page = 1, $limit = 100)
    {

        $query = $this->createQueryBuilder('k')
            ->select('k, b, o')
            ->innerJoin('k.breed', 'b')
            ->innerJoin('k.owner', 'o')
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit)
            ->addOrderBy('k.birthday')
            ->getQuery();

        $query->setHydrationMode(Query::HYDRATE_ARRAY);

        $paginator = new Paginator($query);

        return $paginator;

    }

}