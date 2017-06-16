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
        //Non fonctionnel, à reprendre
/*        $comparator = [];
        $products = $category->getProducts();
        $productsCount = count($products);
        for($i=0; $i<$productsCount; $i++){
            $comparator['products'][$i] = $products[$i];
            $productOptions = $products[$i]->getProductOptions();
            $countProductOptions = count($productOptions);
            for($j=0; $j<$countProductOptions; $j++){
                $comparator['productOptions'][$i][$j] = $productOptions[$j];
            }
        }*/
        return $this->render('AppBundle:CategoryPage:category.html.twig', ['category' => $category]);
    }
}