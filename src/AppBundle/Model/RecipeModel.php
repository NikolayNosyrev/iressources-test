<?php

namespace AppBundle\Model;

use AppBundle\Entity\Recipe;
use Doctrine\ORM\EntityManager;

class RecipeModel
{
    private $em;

    private $recipeRepo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->recipeRepo = $em->getRepository(Recipe::class);
    }

    /**
     * @param $id
     *
     * @return null|Recipe
     */
    public function findOneById($id)
    {
        return $this->recipeRepo->findOneBy(['id' => $id]);
    }

    /**
     * @return array|\AppBundle\Entity\Recipe[]
     */
    public function findAll()
    {
        return $this->recipeRepo->findAll();
    }
}