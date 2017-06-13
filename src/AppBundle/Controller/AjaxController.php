<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class AjaxController extends Controller
{
    /**
     * @Route(
     *     "/ajax/resume/parse",
     *     name="ajax_resume_parse",
     * )
     */
    public function circleUserInvitation(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $client = new Client([
                'base_uri' => 'https://api.catsone.com/',
            ]);
            $resume = $_FILES['resume'];
            $resource = fopen(realpath($resume['tmp_name']), 'r');
            $res = $client->request('POST', '/v3/attachments/parse', [
                'headers' => [
                    'Authorization' => 'Token 52190b469513a91f73c29789304acd48',
                    'content-type' => 'application/octet-stream'
                ],
                'body' => $resource
            ]);
            return new JsonResponse(array('data'=>$res->getBody()->getContents()));
        }
        return $this->redirectToRoute('main');
    }
}
