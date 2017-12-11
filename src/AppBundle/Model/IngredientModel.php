<?php

namespace AppBundle\Model;

use AppBundle\Entity\Ingredient;
use Doctrine\ORM\EntityManager;

class IngredientModel
{
    private $em;

    private $ingredientRepo;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->ingredientRepo = $em->getRepository(Ingredient::class);
    }

    /**
     * @return array|\AppBundle\Entity\Ingredient[]
     */
    public function findAll()
    {
        return $this->ingredientRepo->findAll();
    }

    /**
     * @param $id
     *
     * @return null|Ingredient
     */
    public function findOneById($id)
    {
        return $this->ingredientRepo->findOneBy(['id' => $id]);
    }

    /**
     * @param Ingredient $ingredient
     *
     * @throws \Exception
     */
    public function create(Ingredient $ingredient)
    {
        $this->em->persist($ingredient);
        $this->em->flush();
    }

    /**
     * @param Ingredient $ingredient
     *
     * @throws \Exception
     */
    public function update(Ingredient $ingredient)
    {
        $this->em->persist($ingredient);
        $this->em->flush();
    }

    /**
     * @param Ingredient $ingredient
     *
     * @throws \Exception
     */
    public function delete(Ingredient $ingredient)
    {
        $this->em->remove($ingredient);
        $this->em->flush();
    }
}