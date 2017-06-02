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
        $url = "https://api.catsone.com/v3/jobs";
        $apiKey = '52190b469513a91f73c29789304acd48'; // should match with Server key
        $headers = array(
            'Authorization: Token '.$apiKey
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        dump(json_decode($response));
        die();
        return $this->render('SIAppBundle:Applicant:home.html.twig');
    }
}
