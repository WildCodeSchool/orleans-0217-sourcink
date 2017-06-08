<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryPageController extends Controller
{
    /**
     * @Route(
     *     "/category/{id}",
     *     name="si_app_category",
     *     defaults={"id": 1},
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function categoryAction()
    {
        return $this->render('AppBundle:Category:category.html.twig');
    }
}
