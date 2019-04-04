<?php

namespace SocialProBundle\Controller;

use SocialProBundle\Entity\Events;
use SocialProBundle\Entity\FosUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Event controller.
 *
 */
class EventsController extends Controller
{
    /**
     * Lists all event entities.
     *
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('SocialProBundle:Events')->findBy(array('state' => 'Valid'));
        return $this->render('events/index.html.twig', array(
            'events' => $events,
            'user' => $user
        ));
    }

    public function indexSuggestedAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('SocialProBundle:Events')->findBy(array('idEmployee' => $user,'state'=>'Pending'));

        return $this->render('events/suggest.html.twig', array(
            'events' => $events,
            'user' => $user
        ));
    }

    public function backendAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('SocialProBundle:Events')->findAll();

        return $this->render('Events/backendIndex.html.twig', array(
            'events' => $events,
            'user' => $user
        ));
    }

    /**
     * Creates a new event entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $event = new Events();

        $form = $this->createForm('SocialProBundle\Form\EventsType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $event->setIdEmployee($user);
            $event->setState("Pending");
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    public function newBackendAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $event = new Events();

        $form = $this->createForm('SocialProBundle\Form\EventsType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $event->setIdEmployee($user);
            $event->setState("Valid");
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('events_index_backend');
        }

        return $this->render('events/backendNew.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     */
    public function showAction(Events $event)
    {
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('events/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     */
    public function editAction(Request $request, Events $event)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('SocialProBundle\Form\EventsType', $event);
        $editForm->handleRequest($request);
        $event->setState("Pending");
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user
        ));
    }

    public function backendValidateAction(Request $request, Events $event)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('SocialProBundle:Events')->find($request->attributes->get('id'));

        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('SocialProBundle\Form\EventsType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            return $this->redirectToRoute('events_index_backend');
        }

        return $this->render('events/backendValidate.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user
        ));
    }

    /**
     * Deletes a event entity.
     *
     */
    public function deleteAction(Request $request, Events $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('events_index');
    }

    public function deleteClassicAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository("SocialProBundle:Events");
        $model = $em->find("SocialProBundle:Events", $id);
        $em->remove($model);
        $em->flush();


        return $this->redirectToRoute("events_index");

    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Events $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Events $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('events_delete', array('id' => $event->getEventId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function ajaxeditAction(Request $req)
    {

        $em = $this->getDoctrine()->getManager();
        if ($req->isXmlHttpRequest()) {
            $id = $req->get('id');

            $event = $em->getRepository("SocialProBundle:Events")->find($id);
            $event->setState("Valid");
            $em->persist($event);
            $em->flush();

        }

        return new Response();
    }
}
