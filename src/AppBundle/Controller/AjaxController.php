<?php

namespace AppBundle\Controller;

use AppBundle\Services\Api;
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
    public function resumeParsing(Request $request, Api $api)
    {
        if ($request->isXmlHttpRequest()) {
            $resumeJson = $api->parsing($request);
            $url = $api->createCandidateResume($resumeJson);
            $urlExplode = explode('/',$url);
            $id = $urlExplode[5];
            $api->sendResume($request, $id);
            return new JsonResponse(array('data'=>$resumeJson));
        }
        return $this->redirectToRoute('app_homepage');
    }
}