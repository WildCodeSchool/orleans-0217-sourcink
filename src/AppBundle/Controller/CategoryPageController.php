<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        return $this->render('AppBundle:CategoryPage:category.html.twig', ['category' => $category]);
    }
}