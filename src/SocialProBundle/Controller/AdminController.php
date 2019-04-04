<?php

namespace SocialProBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SocialProBundle\Entity\Posts;
use Symfony\Component\HttpFoundation\Request;
use SocialProBundle\Form\RechercheType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminController extends Controller
{

    public function showUsersAction(){
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render("SocialProBundle:Admin:userlist.html.twig", ['users' => $users]);
    }

    public function showAdsAction(){
        $ads = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->findBy(['status' => "P"]);
        return $this->render("SocialProBundle:Admin:adlist.html.twig", ['ads' => $ads]);
    }

    public function approveAdAction($id){
        $ad = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->find($id);
        $ad->setStatus('A');
        $this->getDoctrine()->getManager()->persist($ad);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('Notice','Ad successfully approved!');
        $twilio = $this->get('twilio.api');

        $message = $twilio->account->messages->sendMessage(
            $this->getParameter('twilio_api_number'), // From a Twilio number in your account
            $ad->getUser()->getPhoneNumber(), // Text any number
            "Your ad \"".$ad->getTitle()."\" has been approved and is now on our feed."
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        $message->sid;
        return $this->redirectToRoute('admin_show_adlist');
    }

    public function refuseAdAction($id){
        $ad = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->find($id);
        $ad->setStatus('R');

        $this->getDoctrine()->getManager()->persist($ad);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('Notice','Ad successfully refused!');
        $twilio = $this->get('twilio.api');

        $message = $twilio->account->messages->sendMessage(
            $this->getParameter('twilio_api_number'), // From a Twilio number in your account
            $ad->getUser()->getPhoneNumber(), // Text any number
            "Your ad \"".$ad->getTitle()."\" has been disapproved as it voilates our terms of services. We apologize for the inconvenience"
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        $message->sid;
        return $this->redirectToRoute('admin_show_adlist');
    }

    public function showPostsAction(){
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository("SocialProBundle:Posts")->findAll();
        return $this->render("SocialProBundle:Admin:postlist.html.twig", ['posts' => $posts]);
    }

    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $modele = $em->getRepository("SocialProBundle:Posts")->find($id);
        $em->remove($modele);
        $em->flush();

        return $this->redirectToRoute('admin_show_postlist');
    }

    public function filtrerAction(){
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('SocialProBundle:Posts')->filterSignalDQL();
        return $this->redirectToRoute('admin_show_postlist');
    }

    public function rechercheUsernameDQLAction(Request $request)
    {
        $post = new Posts();
        $em = $this->getDoctrine()->getManager();
        $posts=$em->getRepository('SocialProBundle:Posts')->findAll();

        $Form = $this->createForm(RechercheType::class,$post);
        $Form->handleRequest($request);
        if($Form->isSubmitted())
        {
            $text=$post->getPostSignal();
            $posts=$em->getRepository("SocialProBundle:Posts")->findUsernameDQL($text);
        }
        return $this->render("SocialProBundle:Admin:recherche.html.twig",array('Form'=>$Form->createView(),'posts'=>$posts));

    }
}
