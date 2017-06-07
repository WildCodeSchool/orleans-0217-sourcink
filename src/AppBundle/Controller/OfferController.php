<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class OfferController extends Controller
{
    /**
     * @Route("/job", name="app_job")
     */
    public function jobAction()
    {
        return $this->render('AppBundle:Job:home.html.twig');
    }
}
