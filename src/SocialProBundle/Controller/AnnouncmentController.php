<?php

namespace SocialProBundle\Controller;

use SocialProBundle\Entity\Announcment;
use SocialProBundle\Entity\Thread;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnouncmentController extends Controller
{

    public function indexAction(Request $request)
    {
        $current = $this->getUser();
        $ad = new Announcment();
        $listeCat = $this->getDoctrine()->getRepository("SocialProBundle:Category")->findAll();
        $catArray["Select a category!"] = null;
        foreach($listeCat as $c){
            $catArray[$c->getName()] = $c->getId();
        }
        $form = $this->createFormBuilder($ad)
            ->add('keywords',TextType::class,
                            array('attr' => array('class' => 'form-control',
                                                  'placeholder' => 'Item keywords')))
            ->add('category', ChoiceType::class, array('attr' => array('class' => 'form-control'),
                'choices' => $catArray))
            ->getForm();
        $form->handleRequest($request);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $uploadDir = $this->getParameter('ad_image_directory');
        if($form->isSubmitted()){
            $count = 0;
            $ads = $this->getDoctrine()
                        ->getRepository("SocialProBundle:Announcment")
                        ->findByCriteras($ad->getKeywords(),
                                         $request->get("price-min"),
                                         $request->get("price-max"),
                                         $ad->getCategory());
            foreach ($ads as $ad){
                if($ad->getStatus() == 'A')
                $count ++;
            }

            $result = $paginator->paginate(
                $ads,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 12)
            );
            return $this->render('SocialProBundle:Ads:index.html.twig', ['ads' => $result,'user' => $current,
                'up_dir' => $uploadDir,'search' => $form->createView(),'count' => $count]);
        }
        $ads = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->orderDesc();

        $result = $paginator->paginate(
            $ads,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 12)
        );
        $uploadDir = $this->getParameter('ad_image_directory');
        return $this->render('SocialProBundle:Ads:index.html.twig', ['ads' => $result,'user' => $current,'up_dir' => $uploadDir,'search' => $form->createView()]);

    }

    public function addAction(Request $request){
        $user = $this->getUser();
        $ad = new Announcment();
        $listeCat = $this->getDoctrine()->getRepository("SocialProBundle:Category")->findAll();
        $catArray = [];
        foreach($listeCat as $c){
            $catArray[$c->getName()] = $c->getId();
        }

        $form = $this->createFormBuilder($ad)
            ->add('title',   TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Item title')))
            ->add('price',   NumberType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Item price')))
            ->add('desc',    TextareaType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Item description')))
            ->add('keywords',TextareaType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Item keywords')))
            ->add('image',   FileType::class, array('data_class' => null, 'attr' => array('class' => 'form-control')))
            ->add('category',ChoiceType::class, array('data_class' => null,
                'attr' => array('class' => 'form-control'),'choices' => $catArray))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $this->getDoctrine()->getRepository("SocialProBundle:Category")->find($form['category']->getData());
            $ad->setCategory($cat);
            $file = $ad->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('ad_image_directory'),
                $fileName
            );
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $ad->setImage($fileName);
            $ad->setUser($user);
            $this->getDoctrine()->getManager()->persist($ad);
            $this->getDoctrine()->getManager()->flush();

            //Thread add part
            $th = new Thread();
            $th->setId($ad->getAnnounceId());
            $th->setPermalink("http://localhost:8000/ads/".$th->getId());
            $th->setCommentable(true);
            $th->setNumComments(0);

            $this->getDoctrine()->getManager()->persist($th);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('announcment_home');
        }
        return $this->render("SocialProBundle:Ads:add.html.twig", ['user' => $user, 'form' => $form->createView()]);
    }

    public function myadsAction(){
        $adCount = 0;
        $user = $this->getUser();
        $myads = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->findBy(['user' => $user]);
        foreach($myads as $ad){
            $adCount ++;
        }
        return $this->render("SocialProBundle:Ads:myads.html.twig", ['user' => $user, 'ad_count' => $adCount ,'ads' => $myads]);
    }

    public function adDetailsAction($id,Request $request){
        $ad = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->find($id);

        $form = $this->createFormBuilder($ad)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Item title')))
            ->add('price', NumberType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Item price')))
            ->add('desc', TextareaType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Item description')))
            ->add('image', FileType::class, array('data_class' => null, 'attr' => array('class' => 'form-control')))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $ad->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('ad_image_directory'),
                $fileName
            );
            $ad->setImage($fileName);
            $ad->setStatus('P');
            $this->getDoctrine()->getManager()->persist($ad);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('Notice','Ad Modified!');
            return $this->redirectToRoute('announcment_myads');
        }
        return $this->render("SocialProBundle:Ads:addetails.html.twig", ['form' => $form->createView()]);
    }

    public function adDeleteAction($id){
        $ad = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->find($id);
        $this->getDoctrine()->getManager()->remove($ad);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('Notice','Ad Deleted');
        return $this->redirectToRoute('announcment_myads');

    }

    public function likeAdAction($id){
        $ad = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->find($id);
        $ad->setLikes($ad->getLikes() + 1);
        $this->getDoctrine()->getManager()->persist($ad);
        $this->getDoctrine()->getManager()->flush();

        return new Response($ad->getLikes());
    }

    public function dislikeAdAction($id){
        $ad = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->find($id);
        $ad->setDislikes($ad->getDislikes() + 1);
        $this->getDoctrine()->getManager()->persist($ad);
        $this->getDoctrine()->getManager()->flush();

        return new Response($ad->getLikes());
    }

    public function someRandomAction($id){
        $user = $this->getUser();
        $ad = $this->getDoctrine()->getRepository("SocialProBundle:Announcment")->find($id);
        return $this->render("SocialProBundle:Ads:showad.html.twig", ['user' => $user,'ad' => $ad]);
    }
}


