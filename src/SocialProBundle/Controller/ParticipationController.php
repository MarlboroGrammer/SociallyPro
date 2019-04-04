<?php

namespace SocialProBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialProBundle\Entity\Events;
use SocialProBundle\Entity\Participation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Participation controller.
 *
 */
class ParticipationController extends Controller
{
    /**
     * @param $id
     */

    /**
     * Lists all participation entities.
     *
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $Eid = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        //$Event = new Events();
        $Event = $em->getRepository('SocialProBundle:Events')->find($Eid);

        $participations = $em->getRepository('SocialProBundle:Participation')->findBy(array('idevent' => $Event));

        return $this->render('participation/index.html.twig', array(
            'participations' => $participations,
            'user' => $user

        ));
    }
    public function ParticipationPerUserAction(Request $request)
    {
        $user = $this->getUser();
        $Eid = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        //$Event = new Events();
        $Event = $em->getRepository('SocialProBundle:Events')->find($Eid);

        $participations = $em->getRepository('SocialProBundle:Participation')->findBy(array('idParticipant'=>$user),array('idevent' => $Event));

        return $this->render('participation/index.html.twig', array(
            'participations' => $participations,
            'user' => $user

        ));
    }

    public function _participateAction(Request $request, $id)
    {
        $user = $this->getUser();
        $Eid = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        //$Event = new Events();
        $Event = $em->getRepository('SocialProBundle:Events')->find($Eid);

        $participation = new Participation();
        //$form = $this->createForm('SocialProBundle\Form\ParticipationType', $participation, array('method' => 'POST'));
        //$form->handleRequest($request);
        $participation->setIdparticipant($user);
        $participation->setIdevent($Event);

        if ($request->isMethod("post")) {
            $participation->setJustification($request->get("motif"));
            $participation->setState($request->get("state"));
            $em = $this->getDoctrine()->getManager();
            $em->persist($participation);
            $em->flush();
            return $this->redirectToRoute('events_index',
                array('id' => $participation->getParticipationId()));
        }

        return $this->render('participation/new.html.twig', array(
            'participation' => $participation,
        ));
    }

    /**
     * @Template()
     * @Route("/",name="participation")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        return array();
    }

    /**
     * Finds and displays a participation entity.
     *
     */
    public function showAction(Participation $participation)
    {

        $deleteForm = $this->createDeleteForm($participation);

        return $this->render('participation/show.html.twig', array(
            'participation' => $participation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing participation entity.
     *
     */
    public function editAction(Request $request, Participation $participation)
    {
        $deleteForm = $this->createDeleteForm($participation);
        $editForm = $this->createForm('SocialProBundle\Form\ParticipationType', $participation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participation_edit', array('id' => $participation->getParticipationId()));
        }

        return $this->render('participation/edit.html.twig', array(
            'participation' => $participation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a participation entity.
     *
     */
    public function deleteAction(Request $request, Participation $participation)
    {
        $form = $this->createDeleteForm($participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($participation);
            $em->flush($participation);
        }

        return $this->redirectToRoute('participation_index');
    }

    /**
     * Creates a form to delete a participation entity.
     *
     * @param Participation $participation The participation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Participation $participation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('participation_delete', array('id' => $participation->getParticipationId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
