<?php

namespace SocialProBundle\Controller;

use SocialProBundle\Entity\Complaint;
use SocialProBundle\Entity\Compmsg;
use SocialProBundle\Form\ComplaintType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Complaint controller.
 *
 */
class ComplaintController extends Controller
{
    /**
     * Lists all complaint entities.
     *
     */
    public function indexAction()
    {   $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $complaints = $em->getRepository('SocialProBundle:Complaint')->findBy(array('employee' => $user));

        return $this->render('complaint/index.html.twig', array(
            'complaints' => $complaints,
            'user' => $user
        ));
    }
    public function backendlistcomplaintAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nbr=$em->getRepository('SocialProBundle:Complaint')->nbrrec();
        $complaints = $em->getRepository('SocialProBundle:Complaint')->findall();

        return $this->render('complaint/adindex.html.twig', array(
            'complaints' => $complaints,
            'nbr' =>$nbr

        ));
    }

    /**
     * Creates a new complaint entity.
     *
     */
    public function newAction(Request $request)
    { $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $complaint = new Complaint();
        $form = $this->createForm('SocialProBundle\Form\ComplaintType', $complaint);
        $form->handleRequest($request);
        $complaint->setDateComplaint(new \DateTime('now'));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $complaint->setEmployee($user);
            $em->persist($complaint);
            $em->flush($complaint);

            return $this->redirectToRoute('complaint_detail', array('id' => $complaint->getComplaintId()));
        }

        return $this->render('complaint/new.html.twig', array(
            'complaint' => $complaint,
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * Finds and displays a complaint entity.
     *
     */
    public function showAction(Complaint $complaint)
    {
        $deleteForm = $this->createDeleteForm($complaint);

        return $this->render('complaint/show.html.twig', array(
            'complaint' => $complaint,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function detailAction(Complaint $complaint,Request $request)
    {   $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $complaint->setSeen('vu');
        $em->persist($complaint);
        $em->flush($complaint);
        $deleteForm = $this->createDeleteForm($complaint);
        $compmsg = new Compmsg();
        $form = $this->createForm('SocialProBundle\Form\CompmsgType', $compmsg);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $compmsg->setUser($user);
            $compmsg->setComplaint($complaint);
            $compmsg->setDate( new \DateTime());
            $em->persist($compmsg);
            $em->flush($compmsg);

            return $this->redirectToRoute('complaint_detail', array('id' => $complaint->getComplaintId()));
        }

        $compmsgs = $em->getRepository('SocialProBundle:Compmsg')->findmsg($complaint);

        $paginator  = $this->get('knp_paginator');

        $blogPosts = $paginator->paginate(
            $compmsgs,
            $request->query->getInt('page',1) /*page number*/,
            4 /*limit per page*/
        );

        return $this->render('complaint/detail.html.twig', array(
            'complaint' => $complaint,
            'delete_form' => $deleteForm->createView(),
            'user' => $user,
            'compmsgs' => $blogPosts,
            'form' =>$form->createView()
        ));
    }
    public function backendshowcomplaintAction(Complaint $complaint,Request $request){
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($complaint);
        $compmsg = new Compmsg();
        $form = $this->createForm('SocialProBundle\Form\CompmsgType', $compmsg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $compmsg->setUser($user);
            $compmsg->setComplaint($complaint);
            $compmsg->setDate( new \DateTime());
            $complaint->setSeen('non vue');
            $em->persist($compmsg,$complaint);
            $em->flush();
            $message = \Swift_Message::newInstance()
                ->setSubject('Complaint'.$complaint->getComplaintId())
                ->setFrom('nizar.hamouda@esprit.tn')
                ->setTo('nizar0895@gmail.com')
                ->setBody('you have received a new message, please check your complaints menu'.'   '.'"'.$compmsg->getMsg().'"'.'  '.$compmsg->getDate()->format('Y-m-d H:i:s'));
            $this->get('mailer')->send($message);
            return $this->redirectToRoute('complaint_show_backend', array('id' => $complaint->getComplaintId()));
        }

        $em = $this->getDoctrine()->getManager();
        $compmsgs = $em->getRepository('SocialProBundle:Compmsg')->findmsgadmin($complaint);

        return $this->render('complaint/adshow.html.twig', array(
            'complaint' => $complaint,
            'delete_form' => $deleteForm->createView(),
            'compmsgs' => $compmsgs,
            'form' =>$form->createView()
        ));
    }
    /**
     * Displays a form to edit an existing complaint entity.
     *
     */
    public function editAction(Request $request, Complaint $complaint)
    {
        $deleteForm = $this->createDeleteForm($complaint);
        $editForm = $this->createForm('SocialProBundle\Form\ComplaintType', $complaint);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('complaint_edit', array('id' => $complaint->getComplaintId()));
        }

        return $this->render('complaint/edit.html.twig', array(
            'complaint' => $complaint,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function ajaxeditAction(Request $req)
    {
       /* $em =$this->getDoctrine()->getManager();
        $complaint=$em->getRepository("SocialProBundle:Complaint")->find($id);
        $complaint->setStatus("done");
        $em->persist($complaint);
        $em->flush();
        return new Response();*/
        $em =$this->getDoctrine()->getManager();
        if($req->isXmlHttpRequest()){
            $id = $req->get('id');
            $complaint=$em->getRepository("SocialProBundle:Complaint")->find($id);
            $complaint->setStatus("done");
            $em->persist($complaint);
            $em->flush();
            return new Response();
        }


    }

    /**
     * Deletes a complaint entity.
     *
     */
    public function deleteAction(Request $request, Complaint $complaint)
    {
        $form = $this->createDeleteForm($complaint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($complaint);
            $em->flush($complaint);
        }

        return $this->redirectToRoute('complaint_index');
    }

    /**
     * Creates a form to delete a complaint entity.
     *
     * @param Complaint $complaint The complaint entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Complaint $complaint)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('complaint_delete', array('id' => $complaint->getComplaintId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
