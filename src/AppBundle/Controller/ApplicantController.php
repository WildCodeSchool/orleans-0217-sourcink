<?php

namespace AppBundle\Controller;

use AppBundle\Services\Api;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/candidat")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="app_applicant")
     */
    public function homeAction(Api $api)
    {
        $data = $api->api('jobs/search?query=CDI', ["field: duration", "filter: contains", "value: rejected"]);
        dump($data);
        die();
        return $this->render('AppBundle:Applicant:home.html.twig');
    }
}
