<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Benefit;
use AppBundle\Entity\ProductOption;

class CategoryPageController extends Controller
{
    /**
     * @Route(
     *     "/categoryPage/{id}",
     *     name="category_page_view",
     *     defaults={"id": 1},
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function categoryAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $benefits = $em->getRepository('AppBundle:Benefit')->findAll();
        return $this->render('AppBundle:CategoryPage:category.html.twig', ['category' => $category, 'benefits' => $benefits]);
    }
}