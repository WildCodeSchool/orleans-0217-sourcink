<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SolutionController extends Controller
{
    /**
     * @Route(
     *     "/solutions/{id}",
     *     name="app_solutions",
     *     defaults={"id": 1},
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Category:category.html.twig');
    }
}

