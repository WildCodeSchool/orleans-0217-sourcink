<?php

namespace SI\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SolutionController extends Controller
{
    /**
     * @Route(
     *     "/solutions/{id}",
     *     name="si_app_solutions",
     *     defaults={"id": 1},
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function indexAction()
    {
        return $this->render('SIAppBundle:Category:category.html.twig');
    }
}

