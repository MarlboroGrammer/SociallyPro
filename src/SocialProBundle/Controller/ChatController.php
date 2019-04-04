<?php

namespace SocialProBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use SocialProBundle\Entity\MarketChat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ChatController extends Controller{

    public function indexAction(){
        $user = $this->getUser();
        $chatHistory = $this->getDoctrine()->getRepository("SocialProBundle:MarketChat")->findAll();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        return $this->render("SocialProBundle:Newsfeed:chat.html.twig", array('current' => $user,
            'history' => $chatHistory));
    }

    public function storeChatAction($id, $message){
        $msg = new MarketChat();
        $msg->setMessage($message);
        $msg->setUser($this->getDoctrine()->getRepository("SocialProBundle:FosUser")->find($id));
        $em = $this->getDoctrine()->getManager();
        $em->persist($msg);
        $em->flush();

        return new Response("Message stored!");

    }
}
