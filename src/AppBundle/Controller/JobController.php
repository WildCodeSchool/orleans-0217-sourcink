<?php

namespace AppBundle\Controller;

use AppBundle\Services\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * @Route("/job", name="app_job")
 */
class JobController extends Controller
{

    const FILTER_JOBS = 'Site Web';
    const HOMESITE_JOBS = 'Homesite';

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
            if ($offers[$job->id]['attachment_id'] != '') {

                $offers[$job->id]['image'] = $api->downloadImg(property_exists($job->_embedded, 'attachments') ? $job->_embedded->attachments[0]->id : '');

            }
        }

        $offerShow = array();

        foreach ($offers as $offer){
            if($offer['statut'] == self::FILTER_JOBS or $offer['statut'] == self::HOMESITE_JOBS) {
                $offerShow[] = $offer;
            }
        }


        /**
         * @var $pagination "Knp\Component\Pager\Paginator"
         * */
        $pagination = $this->get('knp_paginator');
        $results = $pagination->paginate(
            $offerShow,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 9)
        );
        $countUser = 0;
        if($this->getUser()!=null) {
            $catsUser = $api->getSearch('candidates', $this->getUser()->getEmail());
            $countUser = $catsUser->count;
        }
        $hasResume = false;
        if ($countUser > 0) {
            $hasResume = $api->hasResume($catsUser->_embedded->candidates[0]->id);
        }

        return $this->render(
            'AppBundle:Job:home.html.twig',
            [
                'offers' => $results,
                'status' => $countUser,
                'hasResume' => $hasResume,
            ]
        );
    }

    /**
     * @Route("/{id}", name="job_page", requirements={"id": "\d+"})
     */

    public function jobPageAction(Api $service, $id, Request $request, \Swift_Mailer $mailer, Email $email)
    {
        $data = $service->getId('jobs', $id);
        $form = $this->createFormBuilder()
            ->setMethod('POST')
            ->add(
                'Postuler', SubmitType::class, array(
                'label'=> "Postuler",
                'attr'=>array ('class'=> 'waves-effect waves-light btn red'))
            )

            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $users = $service->getSearch('candidates', $this->getUser()->getEmail());
            $user = $users->_embedded->candidates[0];
            $candidat = $service->apply($user, $id);
            $email->applyJob($mailer, $this->getUser(), $data->title);
            $this->addFlash('success', 'Nous avons reçus votre candidature. Nous allons vous contacter par e-mail.');
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

        if ($offer['attachment_id'] != '') {

            $offer['image'] = $service->downloadImg(property_exists($data->_embedded, 'attachments') ? $data->_embedded->attachments[0]->id : '');

        }
        $countUser = 0;
        if($this->getUser()!=null) {
            $catsUser = $service->getSearch('candidates', $this->getUser()->getEmail());
            $countUser = $catsUser->count;
        }
        $hasResume = false;
        if ($countUser > 0) {
            $hasResume = $service->hasResume($catsUser->_embedded->candidates[0]->id);
        }

        return $this->render(
            'AppBundle:Job:page.html.twig',
            [
                'offer' => $offer,

                'form' => $form->createView(),
                'status' => $countUser,
                'hasResume' => $hasResume,
            ]
        );


    }
    /**
     * @Route("/spontane", name="job_spontane")
     */
    public function spontaneAction(\Swift_Mailer $mailer, Email $email)
    {
        $email->candidatureSpontane($mailer, $this->getUser());
        $this->addFlash('success', 'Nous avons reçu votre candidature. Nous allons vous contacter par e-mail.');
        return $this->redirectToRoute('job_list');
    }
}