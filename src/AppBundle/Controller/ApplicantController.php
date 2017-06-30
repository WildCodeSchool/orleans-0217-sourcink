<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProfileType;
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
    public function homeAction()
    {

        return $this->render('AppBundle:Applicant:home.html.twig');
    }

    /**
     * @Route("/update", name="applicant_update")
     */
    public function updateAction(Request $request, Api $api)
    {
        $users = $api->getSearch('candidates', $this->getUser()->getFirstName());
        $user = $users->_embedded->candidates[0];
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $api->updateCandidate($form->getData());
            return $this->redirectToRoute('applicant_update');
        }
        return $this->render('AppBundle:Applicant:update.html.twig', ['user' => $user, 'form' => $form->createView()]);

    }
}
