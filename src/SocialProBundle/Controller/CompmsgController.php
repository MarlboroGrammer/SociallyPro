<?php

namespace SocialProBundle\Controller;

use SocialProBundle\Entity\Compmsg;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Compmsg controller.
 *
 */
class CompmsgController extends Controller
{
    /**
     * Lists all compmsg entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $compmsgs = $em->getRepository('SocialProBundle:Compmsg')->findAll();

        return $this->render('compmsg/index.html.twig', array(
            'compmsgs' => $compmsgs,
        ));
    }

    /**
     * Creates a new compmsg entity.
     *
     */
    public function newAction(Request $request)
    {
        $compmsg = new Compmsg();
        $user = $this->getUser();
        $form = $this->createForm('SocialProBundle\Form\CompmsgType', $compmsg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($compmsg);
            $em->flush($compmsg);

            return $this->redirectToRoute('compmsg_show', array('id' => $compmsg->getId()));
        }

        return $this->render('complaint/detail.html.twig', array(
            'compmsg' => $compmsg,
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * Finds and displays a compmsg entity.
     *
     */
    public function showAction(Compmsg $compmsg)
    {
        $deleteForm = $this->createDeleteForm($compmsg);

        return $this->render('compmsg/show.html.twig', array(
            'compmsg' => $compmsg,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing compmsg entity.
     *
     */
    public function editAction(Request $request, Compmsg $compmsg)
    {
        $deleteForm = $this->createDeleteForm($compmsg);
        $editForm = $this->createForm('SocialProBundle\Form\CompmsgType', $compmsg);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('compmsg_edit', array('id' => $compmsg->getId()));
        }

        return $this->render('compmsg/edit.html.twig', array(
            'compmsg' => $compmsg,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a compmsg entity.
     *
     */
    public function deleteAction(Request $request, Compmsg $compmsg)
    {
        $form = $this->createDeleteForm($compmsg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($compmsg);
            $em->flush($compmsg);
        }

        return $this->redirectToRoute('compmsg_index');
    }

    /**
     * Creates a form to delete a compmsg entity.
     *
     * @param Compmsg $compmsg The compmsg entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Compmsg $compmsg)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('compmsg_delete', array('id' => $compmsg->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
