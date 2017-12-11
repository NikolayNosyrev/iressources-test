<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CookbookController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
        $recipes = $this->get('model.recipe')->findAll();

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
        return $this->render(
            'AppBundle:Cookbook:create.html.twig',
            [
            ]
        );
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function editAction($id)
    {
        exit;
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function deleteAction($id)
    {
        exit;
    }
}
