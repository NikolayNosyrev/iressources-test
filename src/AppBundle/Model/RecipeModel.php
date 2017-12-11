<?php

namespace AppBundle\Model;

use AppBundle\Entity\Recipe;
use Doctrine\ORM\EntityManager;

class RecipeModel
{
    private $em;

    private $recipeRepo;

    /**
     * @param EntityManager $em
     */
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

    /**
     * @param Recipe $recipe
     *
     * @throws \Exception
     */
    public function create(Recipe $recipe)
    {
        $this->em->persist($recipe);
        $this->em->flush();
    }

    /**
     * @param Recipe $recipe
     *
     * @throws \Exception
     */
    public function update(Recipe $recipe)
    {
        $this->em->persist($recipe);
        $this->em->flush();
    }

    /**
     * @param Recipe $recipe
     *
     * @throws \Exception
     */
    public function delete(Recipe $recipe)
    {
        $this->em->remove($recipe);
        $this->em->flush();
    }
}