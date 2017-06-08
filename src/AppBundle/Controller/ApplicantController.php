<?php

namespace AppBundle\Controller;

use AppBundle\Services\Api;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


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
        //curl -X POST https://api.catsone.com/v3/attachments/parse
        // -H 'authorization: Token 52190b469513a91f73c29789304acd48'
        // -H 'content-type: application/octet-stream'
        // --data-binary @cv.txt
        $post = array('filename' => '@'.realpath('./upload/cv.txt'));
        dump($post);
        $url = 'https://api.catsone.com/v3/attachments/parse';
        $apiKey = '52190b469513a91f73c29789304acd48';
        $headers = array('Authorization: Token '.$apiKey, 'content-type: application/octet-stream');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
        dump($ch);
        $response = curl_exec($ch);
        curl_close($ch);
        dump($response);
        die();
    }
}