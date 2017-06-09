<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Header;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Header controller.
 *
 * @Route("header")
 */
class HeaderController extends Controller
{
    /**
     * Lists all header entities.
     *
     * @Route("/", name="header_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $headers = $em->getRepository('AppBundle:Header')->findAll();

        return $this->render('Admin/header/index.html.twig', array(
            'headers' => $headers,
        ));
    }

    /**
     * Creates a new header entity.
     *
     * @Route("/new", name="header_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $header = new Header();
        $form = $this->createForm('AppBundle\Form\HeaderType', $header);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($header);
            $em->flush();

            return $this->redirectToRoute('header_show', array('id' => $header->getId()));
        }

        return $this->render('Admin/header/new.html.twig', array(
            'header' => $header,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a header entity.
     *
     * @Route("/{id}", name="header_show")
     * @Method("GET")
     */
    public function showAction(Header $header)
    {
        $deleteForm = $this->createDeleteForm($header);

        return $this->render('Admin/header/show.html.twig', array(
            'header' => $header,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing header entity.
     *
     * @Route("/{id}/edit", name="header_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Header $header)
    {
        $deleteForm = $this->createDeleteForm($header);
        $editForm = $this->createForm('AppBundle\Form\HeaderType', $header);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('header_edit', array('id' => $header->getId()));
        }

        return $this->render('Admin/header/edit.html.twig', array(
            'header' => $header,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a header entity.
     *
     * @Route("/{id}", name="header_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Header $header)
    {
        $form = $this->createDeleteForm($header);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($header);
            $em->flush();
        }

        return $this->redirectToRoute('header_index');
    }

    /**
     * Creates a form to delete a header entity.
     *
     * @param Header $header The header entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Header $header)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('header_delete', array('id' => $header->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
