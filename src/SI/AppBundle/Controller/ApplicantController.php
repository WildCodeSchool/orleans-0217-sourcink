<?php

namespace SI\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/candidat")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="si_app_applicant")
     */
    public function homeAction()
    {
        $services = $this->container->get('si_app.api');
        $data = $services->api('jobs/search?query=CDI', ["field: duration", "filter: contains", "value: rejected"]);
        dump($data);
        die();
        return $this->render('SIAppBundle:Applicant:home.html.twig');
    }
}
