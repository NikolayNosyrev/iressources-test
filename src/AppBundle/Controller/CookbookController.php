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
    public function listAction(Request $request)
    {
        $recipes = $this->get('model.recipe')->findAll();

        return $this->render('AppBundle:Cookbook:list.html.twig', [
            'recipes' => $recipes
        ]);
    }
}
