<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;


/**
 * @Route("/candidat")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="app_applicant")
     */
    public function homeAction()
    {
/*        $client = new Client([
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
        dump($res->getBody()->getContents());*/

/*        $client = new Client([
            'base_uri' => 'https://api.catsone.com/',
        ]);
        $infos = [
            "first_name" => "Test",
            "last_name" => "Test",
        ];
        $candidateInfos = json_encode($infos);
        dump($candidateInfos);
        $candidate = $client->request('POST', '/v3/candidates?check_duplicate=true', [
            'headers' => [
                'Authorization' => 'Token 52190b469513a91f73c29789304acd48',
                'content-type' => 'application/json'
            ],
            'json' => [
                "first_name" => "Test",
                "last_name" => "Test",
            ]
        ]);
        dump($candidate);*/
       // $text = explode('/','https://api.catsone.com/v3/candidates/209834207');
        //dump($text);
        //die;
        //return $this->render('AppBundle:Home:home.html.twig', ['offers' => $offers]);

        //Il faut que nous stockions l'ID de l'offre pour pouvoir infomer Cats de l'offre sur laquelle vient de postuler le candidat.'
        // il faut que nous stockions également l'ID du candidat dans notre base pour matcher dessus.



    }
}


