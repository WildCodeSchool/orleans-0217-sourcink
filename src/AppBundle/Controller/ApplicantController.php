<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;


/**
 * @Route("/candidat", name="si_app_applicant")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="si_app_applicant")
     */
    public function homeAction()
    {
        $client = new Client([
            'base_uri' => 'https://api.catsone.com/',
        ]);
        $resource = fopen(realpath('./upload/cv.pdf'), 'r');
        $res = $client->request('POST', '/v3/attachments/parse', [
            'headers' => [
                'Authorization' => 'Token 52190b469513a91f73c29789304acd48',
                'content-type' => 'application/octet-stream'
            ],
            'body' => $resource
        ]);
        dump($res->getBody()->getContents());
    }
}
