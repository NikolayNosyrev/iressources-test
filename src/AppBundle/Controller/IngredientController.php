<?php

namespace AppBundle\Controller;

use AppBundle\Form\IngredientForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IngredientController extends Controller
{
    /**
     * @Route("/ingredients", name="ingredient_list")
     */
    public function listAction(Request $request)
    {
        $ingredients = $this->get('model.ingredient')->findAll();

        return $this->render(
            'AppBundle:Ingredient:list.html.twig',
            [
                'ingredients' => $ingredients,
            ]
        );
    }

    /**
     * @Route("/ingredient/create", name="ingredient_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(IngredientForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('model.ingredient')->create($form->getData());

            $this->addFlash('message', 'Ингредиент успешно добавлен');

            return $this->redirectToRoute('ingredient_list');
        }

        return $this->render(
            'AppBundle:Ingredient:create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/ingredient/edit/{id}", name="ingredient_edit")
     */
    public function editAction($id, Request $request)
    {
        $ingredient = $this->get('model.ingredient')->findOneById($id);

        if (is_null($ingredient)) {
            throw new NotFoundHttpException('Ingredient not found.');
        }

        $form = $this->createForm(IngredientForm::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('model.ingredient')->update($form->getData());

            $this->addFlash('message', 'Ингредиент успешно отредактирован');

            return $this->redirectToRoute('ingredient_list');
        }

        return $this->render(
            'AppBundle:Ingredient:create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/ingredient/delete/{id}", name="ingredient_delete")
     */
    public function deleteAction($id)
    {
        $ingredient = $this->get('model.ingredient')->findOneById($id);

        if (is_null($ingredient)) {
            throw new NotFoundHttpException('Ingredient not found.');
        }

        $this->get('model.ingredient')->delete($ingredient);

        $this->addFlash('message', 'Ингредиент успешно удалён');

        return $this->redirectToRoute('ingredient_list');
    }
}
