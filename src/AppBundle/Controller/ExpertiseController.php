<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Expertise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Expertise controller.
 *
 * @Route("expertise")
 */
class ExpertiseController extends Controller
{
    /**
     * Lists all expertise entities.
     *
     * @Route("/", name="expertise_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $expertises = $em->getRepository('SIAppBundle:Expertise')->findAll();

        return $this->render('Admin/expertise/index.html.twig', array(
            'expertises' => $expertises,
        ));
    }

    /**
     * Creates a new expertise entity.
     *
     * @Route("/new", name="expertise_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $expertise = new Expertise();
        $form = $this->createForm('SI\AppBundle\Form\ExpertiseType', $expertise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expertise);
            $em->flush();

            return $this->redirectToRoute('expertise_show', array('id' => $expertise->getId()));
        }

        return $this->render('Admin/expertise/new.html.twig', array(
            'expertise' => $expertise,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a expertise entity.
     *
     * @Route("/{id}", name="expertise_show")
     * @Method("GET")
     */
    public function showAction(Expertise $expertise)
    {
        $deleteForm = $this->createDeleteForm($expertise);

        return $this->render('Admin/expertise/show.html.twig', array(
            'expertise' => $expertise,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing expertise entity.
     *
     * @Route("/{id}/edit", name="expertise_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Expertise $expertise)
    {
        $deleteForm = $this->createDeleteForm($expertise);
        $editForm = $this->createForm('SI\AppBundle\Form\ExpertiseType', $expertise);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expertise_edit', array('id' => $expertise->getId()));
        }

        return $this->render('Admin/expertise/edit.html.twig', array(
            'expertise' => $expertise,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a expertise entity.
     *
     * @Route("/{id}", name="expertise_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Expertise $expertise)
    {
        $form = $this->createDeleteForm($expertise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expertise);
            $em->flush();
        }

        return $this->redirectToRoute('expertise_index');
    }

    /**
     * Creates a form to delete a expertise entity.
     *
     * @param Expertise $expertise The expertise entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Expertise $expertise)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expertise_delete', array('id' => $expertise->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
