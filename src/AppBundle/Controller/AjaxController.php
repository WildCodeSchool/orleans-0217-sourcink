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
    public function resumeParsing(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $client = new Client([
                'base_uri' => $this->getParameter('app.api.url'),
            ]);
            $resume = $_FILES['resume'];
            $filename = realpath($resume['tmp_name']);
            //Parsing
            $resource = fopen($filename, 'r');
            $parsing = $client->request('POST', 'attachments/parse', [
                'headers' => [
                    'Authorization' => 'Token '.$this->getParameter('app.api.key'),
                    'content-type' => 'application/octet-stream'
                ],
                'body' => $resource
            ]);
            $resumeJson = $parsing->getBody()->getContents();
            $resumeData = json_decode($resumeJson);
            $candidate = $client->request('POST', 'candidates?check_duplicate=false', [
                'headers' => [
                    'Authorization' => 'Token '.$this->getParameter('app.api.key'),
                    'content-type' => 'application/json'
                ],
                'json' => [
                    "first_name" => $resumeData->first_name,
                    "last_name" => $resumeData->last_name,
                    "emails" =>[
                        "primary"=>$resumeData->emails->primary
                    ]
                ]
            ]);
            $url = $candidate->getHeaders()['Location'][0];
            $urlExplode = explode('/',$url);
            $id = $urlExplode[5];
            //Resume
            $resume = $client->request('POST', 'candidates/'.$id.'/resumes?filename=cv.pdf', [
                'headers' => [
                    'Authorization' => 'Token '.$this->getParameter('app.api.key'),
                    'content-type' => 'application/octet-stream'
                ],
                'body' => fopen($filename, 'r')
            ]);
            return new JsonResponse(array('data'=>$resumeJson));
        }
        return $this->redirectToRoute('main');
    }
}