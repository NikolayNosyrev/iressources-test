<?php

namespace AppBundle\Controller;

use AppBundle\Form\RecipeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CookbookController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction(Request $request)
    {
        $search = $request->get('search');

        $recipes = $this->get('model.recipe')->findByString($search);

        return $this->render(
            'AppBundle:Cookbook:list.html.twig',
            [
                'recipes' => $recipes,
            ]
        );
    }

    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(RecipeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('model.recipe')->create($form->getData());

            $this->addFlash('message', 'Рецепт успешно добавлен');

            return $this->redirectToRoute('list');
        }

        return $this->render(
            'AppBundle:Cookbook:create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/edit/{id}", name="edit")
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

            return $this->redirectToRoute('list');
        }

        return $this->render(
            'AppBundle:Cookbook:create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $recipe = $this->get('model.recipe')->findOneById($id);

        if (is_null($recipe)) {
            throw new NotFoundHttpException('Recipe not found.');
        }

        $this->get('model.recipe')->delete($recipe);

        $this->addFlash('message', 'Рецепт успешно удалён');

        return $this->redirectToRoute('list');
    }
}
