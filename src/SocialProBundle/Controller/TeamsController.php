<?php

namespace SocialProBundle\Controller;

use SocialProBundle\Entity\FosUser;
use SocialProBundle\Entity\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Team controller.
 *
 */
class TeamsController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('SocialProBundle:Teams')->findAll();
        return $this->render('SocialProBundle:Admin:teams/index.html.twig', array(
            'teams' => $teams,
        ));
    }

    public function newAction(Request $request)
    {
        $team = new Teams();
        $form = $this->createForm('SocialProBundle\Form\TeamsType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush($team);
            return $this->redirectToRoute('teams_index');
        }
        return $this->render('SocialProBundle:Admin:teams/new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }


    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('SocialProBundle:Teams')->find($id);
        $user =  $em->getRepository('SocialProBundle:FosUser')->findBy(array("teams" => $teams ));
        return $this->render('SocialProBundle:Admin:teams/show.html.twig', array(
            'teams' => $teams,
            'user'=> $user
        ));
    }


    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository('SocialProBundle:Teams')->find($id);

        $editForm = $this->createForm('SocialProBundle\Form\TeamsType', $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('teams_index');
        }

        return $this->render('SocialProBundle:Admin:teams/edit.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
        ));
    }


    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('SocialProBundle:Teams')->find($id);
        $em->remove($teams);
        $em->flush();

        return $this->redirectToRoute('teams_index');
    }
    public function addmembreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('SocialProBundle:Teams')->find($id);
        $user =  $em->getRepository('SocialProBundle:FosUser')->findBy(array("teams" => null ));

        return $this->render('SocialProBundle:Admin:teams/membre.html.twig', array(
            'user' => $user,
            'teams'=> $teams

        ));
    }
    public function addAction($id,$id1)
    {
        $user = new FosUser();
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('SocialProBundle:Teams')->find($id);
        $user =  $em->getRepository('SocialProBundle:FosUser')->find($id1);
        $user->setTeams($teams);
        $em->flush();
        return $this->redirectToRoute('teams_index');
    }

    public function suppmembreAction($id)
    {
        $user = new FosUser();
        $em = $this->getDoctrine()->getManager();
        $user =  $em->getRepository('SocialProBundle:FosUser')->find($id);
        $user->setTeams(null);
        $em->flush();
        return $this->redirectToRoute('teams_index');
    }
    public function frontAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $teams = $em->getRepository('SocialProBundle:Teams')->findAll();

        return $this->render('SocialProBundle:Newsfeed:Teams.html.twig', array(
            'user' => $user,
            'tasks'=>$teams

        ));
    }
    public function membreteamsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $teams = $em->getRepository('SocialProBundle:Teams')->findAll();
        $users =  $em->getRepository('SocialProBundle:FosUser')->findBy(array("teams" => $teams ));
        return $this->render('SocialProBundle:Newsfeed:Membre.html.twig', array(
            'user' => $user,
            'tasks'=>$users

        ));
    }




}
