<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository
{
    /**
     * @param string $search
     *
     * @return array|\AppBundle\Entity\Recipe[]
     */
    public function findByString($search)
    {
        return $this->createQueryBuilder('r')
            ->where('r.name LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }
}
