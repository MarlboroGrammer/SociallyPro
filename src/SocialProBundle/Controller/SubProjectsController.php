<?php

namespace SocialProBundle\Controller;

use Github\Client;
use SocialProBundle\Entity\Jobs;
use SocialProBundle\Entity\SubProjects;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Subproject controller.
 *
 */
class SubProjectsController extends Controller
{
    /**
     * Lists all subProject entities.
     *
     */
    public function _SubsAction(Request $request)
    {
        $subProjects= new SubProjects();
        $Pid= $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $User=$this->get('security.token_storage')->getToken()->getUser();
        $Dir=new Jobs(1,'DIRECTOR');
        $Man=new Jobs(2,'PROJECT MANAGER');
        $TL= new Jobs(3,'TEAM LEADER');
        $Project=$em->getRepository('SocialProBundle:Projects')->find($Pid);
        if (($User->getJob()->getJobId()==1)||($User->getJob()->getJobId()==2)){
        $subProjects = $em->getRepository('SocialProBundle:SubProjects')->findBy(array('project'=>$Project));
    }
    elseif (($User->getJob()->getJobId()==3)||($User->getJob()==null))
    {
        $subProjects = $em->getRepository('SocialProBundle:SubProjects')->findBy(array('project'=>$Project,'team'=>$User->getTeam()));
    }
        return $this->render('subprojects/index.html.twig', array(
            'subProjects' => $subProjects,
        ));
    }

    /**
     * @template()
     * @Route("/", name="subprojects")
     */
    public function indexAction(Request $request)
    {

    }

    /**
     * Creates a new subProject entity.
     *
     */
    public function newAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Pid= $request->attributes->get('id');
        $subProject = new SubProjects();
        $Project=$em->getRepository('SocialProBundle:Projects')->find($Pid);
        $teams=$em->getRepository('SocialProBundle:SubProjects')->findfreeTeamsQB();
        $form = $this->createForm('SocialProBundle\Form\SubProjectsType', $subProject,array('Project'=>$Project));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subProject);
            $em->flush($subProject);
            $fs= new Filesystem();
            try {
                $fs->mkdir('C:/Users/LordGoats/Desktop/My Projects/'.$Project->getProjectName().'/'.$subProject->getSubProjectName());
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
            return $this->redirectToRoute('subprojects_show', array('id' => $subProject->getSubprojectId()));
        }

        return $this->render('subprojects/new.html.twig', array(
            'subProject' => $subProject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subProject entity.
     *
     */
    public function showAction(SubProjects $subProject)
    {
        $deleteForm = $this->createDeleteForm($subProject);

        return $this->render('subprojects/show.html.twig', array(
            'subProject' => $subProject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subProject entity.
     *
     */
    public function editAction(Request $request, SubProjects $subProject)
    {
        $deleteForm = $this->createDeleteForm($subProject);
        $editForm = $this->createForm('SocialProBundle\Form\SubProjectsType', $subProject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subprojects_edit', array('id' => $subProject->getSubProjectId()));
        }

        return $this->render('subprojects/edit.html.twig', array(
            'subProject' => $subProject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subProject entity.
     *
     */
    public function deleteAction(Request $request, SubProjects $subProject)
    {
        $form = $this->createDeleteForm($subProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subProject);
            $em->flush($subProject);
        }

        return $this->redirectToRoute('subprojects_index');
    }

    /**
     * Creates a form to delete a subProject entity.
     *
     * @param SubProjects $subProject The subProject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SubProjects $subProject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subprojects_delete', array('id' => $subProject->getSubProjectId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
