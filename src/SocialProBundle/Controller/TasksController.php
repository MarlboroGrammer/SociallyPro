<?php

namespace SocialProBundle\Controller;

use SocialProBundle\Entity\Tasks;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TasksController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $em->getRepository('SocialProBundle:Tasks')->findAll();

        return $this->render('SocialProBundle:Admin:tasks/index.html.twig', array(
            'tasks' => $tasks,
        ));
    }


    public function newAction(Request $request)
    {
        $tasks = new Tasks();
        $form = $this->createForm('SocialProBundle\Form\TasksType', $tasks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $status = "todo";
            $tasks->setStatus($status);
            $em->persist($tasks);
            $em->flush($tasks);

            return $this->redirectToRoute('tasks_index');
        }

        return $this->render('SocialProBundle:Admin:tasks/new.html.twig', array(
            'task' => $tasks,
            'form' => $form->createView(),
        ));
    }



    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('SocialProBundle:Tasks')->find($id);
        $editForm = $this->createForm('SocialProBundle\Form\TasksType', $task);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tasks_index');
        }

        return $this->render('SocialProBundle:Admin:tasks/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
        ));
    }


    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('SocialProBundle:Tasks')->find($id);
        $em->remove($tasks);
        $em->flush();


        return $this->redirectToRoute('tasks_index');
    }
    public function doingAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('SocialProBundle:Tasks')->find($id);
        $status = "doing";
        $tasks->setStatus($status);
        $em->flush();


        return $this->redirectToRoute('tasks_index');
    }
    public function donAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('SocialProBundle:Tasks')->find($id);
        $status = "don";
        $tasks->setStatus($status);
        $em->flush();


        return $this->redirectToRoute('tasks_index');
    }
    //////frontofice
    public function frontAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $tasks = $em->getRepository('SocialProBundle:Tasks')->findAll();

        return $this->render('SocialProBundle:Newsfeed:Tassk.html.twig', array(
            'user' => $user,
            'tasks'=>$tasks

        ));
    }


}
