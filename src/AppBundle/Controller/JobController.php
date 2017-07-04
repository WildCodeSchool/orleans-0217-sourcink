<?php

namespace AppBundle\Controller;

use AppBundle\Services\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/job", name="app_job")
 */
class JobController extends Controller
{
    /**
     * @Route("/", name="job_list")
     */

    public function jobAction(Api $api, Request $request)
    {

        $data = $api->get('jobs');


        foreach ($data->_embedded->jobs as $job) {
            $offers[$job->id] =
                [
                    'title' => $job->title,
                    'duration' => $job->duration,
                    'description' => $job->description,
                    'city' => trim(ucfirst(strtolower($job->location->city))),
                    'statut' => $job->_embedded->status->title,
                    'maj' => $job->date_modified,
                    'debut' => $job->start_date,
                    'id' => $job->id,
                    'attachment_id' => (property_exists($job->_embedded, 'attachments') ? $job->_embedded->attachments[0]->id : '')
                ];

        }
        $link_site = $this->getParameter('link_site');

        /**
         * @var $pagination "Knp\Component\Pager\Paginator"
         * */
        $pagination = $this->get('knp_paginator');
        $results = $pagination->paginate(
            $offers,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 9)
        );


        return $this->render(
            'AppBundle:Job:home.html.twig',
            [
                'offers' => $results,
                'link_site' => $link_site,
            ]
        );
    }

    /**
     * @Route("/view/{id}", name="job_page")
     */ 
    public function jobPageAction(Api $service, $id, Request $request, \Swift_Mailer $mailer, Email $email)
    {
        $data = $service->getId('jobs', $id);
        $form = $this->createFormBuilder()
            ->setMethod('POST')
            ->add('Postuler', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);


        if ($form->isValid() && $form->isSubmitted()) {
            $users = $service->getSearch('candidates', $this->getUser()->getEmail());
            $user = $users->_embedded->candidates[0];
            $candidat = $service->apply($user, $id);
            $email->applyJob($mailer, $this->getUser(), $data->title);
            $this->addFlash('success', 'Nous avons reçu votre candidature. Nous allons vous envoyer un mail dans les plus brefs délais');
            return $this->render('AppBundle:Job:response.html.twig');
        }


        $offer = [
            'job'=>$data->id,
            'id' => $data->id,
            'title' => $data->title,
            'duration' => $data->duration,
            'description' => $data->description,
            'city' => trim(ucfirst(strtolower($data->location->city))),
            'statut' => $data->_embedded->status->title,
            'maj' => $data->date_modified,
            'debut' => $data->start_date,
            'attachment_id' => (property_exists($data->_embedded, 'attachments') ? $data->_embedded->attachments[0]->id : '')

        ];

        return $this->render(
            'AppBundle:Job:page.html.twig',
            [
                'offer' => $offer,

                'form' => $form->createView(),
                'link_site' =>$link_site = $this->getParameter('link_site')
            ]
        );


    }
    /**
     * @Route("/spontane", name="job_spontane")
     */
    public function spontaneAction(\Swift_Mailer $mailer, Email $email)
    {
        $this->addFlash('success', 'Nous avons bien reçu votre candidature. Nous allons vous contacter par mail.');
        $email->candidatureSpontane($mailer, $this->getUser());
        return $this->redirectToRoute('job_list');
    }
}