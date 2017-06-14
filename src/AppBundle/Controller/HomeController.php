<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homeAction()
    {
        return $this->render('AppBundle:Home:home.html.twig');
    }

}
