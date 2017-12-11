<?php

namespace AppBundle\Controller;

use AppBundle\Form\RecipeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipeController extends Controller
{
    /**
     * @Route("/", name="recipe_list")
     */
    public function listAction(Request $request)
    {
        $search = $request->get('search');

        $recipes = $this->get('model.recipe')->findByString($search);

        return $this->render(
            'AppBundle:Recipe:list.html.twig',
            [
                'recipes' => $recipes,
            ]
        );
    }

    /**
     * @Route("/view/{id}", name="recipe_view")
     */
    public function viewAction($id)
    {
        $recipe = $this->get('model.recipe')->findOneById($id);

        if (is_null($recipe)) {
            throw new NotFoundHttpException('Recipe not found.');
        }

        return $this->render(
            'AppBundle:Recipe:view.html.twig',
            [
                'recipe' => $recipe
            ]
        );
    }

    /**
     * @Route("/create", name="recipe_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(RecipeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('model.recipe')->create($form->getData());

            $this->addFlash('message', 'Рецепт успешно добавлен');

            return $this->redirectToRoute('recipe_list');
        }

        return $this->render(
            'AppBundle:Recipe:create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/edit/{id}", name="recipe_edit")
     */
    public function editAction($id, Request $request)
    {
        $recipe = $this->get('model.recipe')->findOneById($id);

        if (is_null($recipe)) {
            throw new NotFoundHttpException('Recipe not found.');
        }

        $form = $this->createForm(RecipeForm::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('model.recipe')->update($form->getData());

            $this->addFlash('message', 'Рецепт успешно отредактирован');

            return $this->redirectToRoute('recipe_list');
        }

        return $this->render(
            'AppBundle:Recipe:create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="recipe_delete")
     */
    public function deleteAction($id)
    {
        $recipe = $this->get('model.recipe')->findOneById($id);

        if (is_null($recipe)) {
            throw new NotFoundHttpException('Recipe not found.');
        }

        $this->get('model.recipe')->delete($recipe);

        $this->addFlash('message', 'Рецепт успешно удалён');

        return $this->redirectToRoute('recipe_list');
    }
}
