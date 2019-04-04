<?php

namespace SocialProBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller{

    public function indexAction()
    {
        return $this->render('SocialProBundle:Default:index.html.twig');
    }

    public function newsfeedAction(){
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        return $this->render('SocialProBundle:Newsfeed:show.html.twig', array('user' => $user));
    }

    public function adminAction(){
        return $this->render('SocialProBundle:Admin:index.html.twig');
    }
}
