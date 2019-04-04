<?php

namespace SocialProBundle\Controller;

use SocialProBundle\Entity\Jobs;
use SocialProBundle\Entity\Projects;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Project controller.
 *
 */
class ProjectsController extends Controller
{
    /**
     * Lists all project entities.
     *
     */
    Private $Snappy=0;
    Private $RdrProject;

    /**
     * @return mixed
     */
    public function getRdrProject()
    {
        return $this->RdrProject;
    }

    /**
     * @param mixed $RdrProject
     */
    public function setRdrProject($RdrProject)
    {
        $this->RdrProject = $RdrProject;
    }

    /**
     * @return mixed
     */
    public function getSnappy()
    {
        return $this->Snappy;
    }

    /**
     * @param mixed $Snappy
     */
    public function setSnappy($Snappy)
    {
        $this->Snappy = $Snappy;
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $User=$this->getUser();
        $projects = $em->getRepository('SocialProBundle:Projects')->findBy(array('manager'=>$User));
        $Dir=new Jobs(1,"DIRECTOR");
        $Dir=new Jobs(1,"DIRECTOR");
        $Man=new Jobs(2,'PROJECT MANAGER');
        $TL= new Jobs(3,'TEAM LEADER');

        if($User->getJob()->getJobId()==1){
            $projects = $em->getRepository('SocialProBundle:Projects')->findAll();
        }
        elseif (($User->getJob()->getJobId()==3)||($User->getJob()->getJobId()==null)){
            return new Response("You are not Allowed here");
        }
        else{
            $projects = $em->getRepository('SocialProBundle:Projects')->findBy(array('manager'=>$User));
        }
        return $this->render('projects/index.html.twig', array(
                'projects' => $projects,
                'User'=>$User,
                'Dir'=>$Dir
            )
        );
    }

    public function GetProject($id)
    {
        $em=$this->getDoctrine()->getManager();
        return array('Project'=>$em->getRepository('SocialProBundle:Projects')->find($id));

    }

    /**
     * Creates a new project entity.
     *
     */
    public function newAction(Request $request)

    {
        $em = $this->getDoctrine()->getManager();
        $Manager=$em->getRepository('SocialProBundle:SubProjects')->findManagersQB();
        $project = new Projects();
        $form = $this->createForm('SocialProBundle\Form\ProjectsType', $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush($project);
            $fs = new Filesystem();
            $deleteForm = $this->createDeleteForm($project);
            try {
                $fs->mkdir('C:/Users/salah/Desktop/My Projects/'.$project->getProjectName());
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
            //$Show=$this->render('projects/show.html.twig',array('project' => $project,'id'=>$project->getProjectId(), 'delete_form' => $deleteForm->createView()));
            //$this->get('knp_snappy.image')->generateFromHtml($Show,'C:/Users/LordGoats/Desktop/My Projects/'.$project->getProjectName().'/'.$project->getProjectName().'(Show)'.$Snappy+1.'.jpeg');
            //$this->get('knp_snappy.pdf')->generateFromHtml($Show,'C:/Users/LordGoats/Desktop/My Projects/'.$project->getProjectName().'/'.$project->getProjectName().'(Show).pdf');
            return $this->redirectToRoute('projects_show', array('id' => $project->getProjectId()));
        }

        return $this->render('projects/new.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     */
    public function showAction(Projects $project)
    {
        $deleteForm = $this->createDeleteForm($project);

        return $this->render('projects/show.html.twig', array(
            'project' => $project,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing project entity.
     *
     */
    public function editAction(Request $request, Projects $project)
    {
        $deleteForm = $this->createDeleteForm($project);
        $editForm = $this->createForm('SocialProBundle\Form\ProjectsType', $project);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projects_edit', array('id' => $project->getProjectId()));
        }

        return $this->render('projects/edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a project entity.
     *
     */
    public function deleteAction(Request $request, Projects $project)
    {
        $form = $this->createDeleteForm($project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
          $em->flush();
        }

        return $this->redirectToRoute('projects_index');
    }

    /**
     * Creates a form to delete a project entity.
     *
     * @param Projects $project The project entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Projects $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('projects_delete', array('id' => $project->getProjectId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
