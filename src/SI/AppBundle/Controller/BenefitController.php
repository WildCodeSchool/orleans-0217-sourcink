<?php

namespace SI\AppBundle\Controller;

use SI\AppBundle\Entity\Benefit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Benefit controller.
 *
 * @Route("benefit")
 */
class BenefitController extends Controller
{
    /**
     * Lists all benefit entities.
     *
     * @Route("/", name="benefit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $benefits = $em->getRepository('SIAppBundle:Benefit')->findAll();

        return $this->render('admin/benefit/index.html.twig', array(
            'benefits' => $benefits,
        ));
    }

    /**
     * Creates a new benefit entity.
     *
     * @Route("/new", name="benefit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $benefit = new Benefit();
        $form = $this->createForm('SI\AppBundle\Form\BenefitType', $benefit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($benefit);
            $em->flush();

            return $this->redirectToRoute('benefit_show', array('id' => $benefit->getId()));
        }

        return $this->render('admin/benefit/new.html.twig', array(
            'benefit' => $benefit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a benefit entity.
     *
     * @Route("/{id}", name="benefit_show")
     * @Method("GET")
     */
    public function showAction(Benefit $benefit)
    {
        $deleteForm = $this->createDeleteForm($benefit);

        return $this->render('admin/benefit/show.html.twig', array(
            'benefit' => $benefit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing benefit entity.
     *
     * @Route("/{id}/edit", name="benefit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Benefit $benefit)
    {
        $deleteForm = $this->createDeleteForm($benefit);
        $editForm = $this->createForm('SI\AppBundle\Form\BenefitType', $benefit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('benefit_edit', array('id' => $benefit->getId()));
        }

        return $this->render('admin/benefit/edit.html.twig', array(
            'benefit' => $benefit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a benefit entity.
     *
     * @Route("/{id}", name="benefit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Benefit $benefit)
    {
        $form = $this->createDeleteForm($benefit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($benefit);
            $em->flush();
        }

        return $this->redirectToRoute('benefit_index');
    }

    /**
     * Creates a form to delete a benefit entity.
     *
     * @param Benefit $benefit The benefit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Benefit $benefit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('benefit_delete', array('id' => $benefit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
