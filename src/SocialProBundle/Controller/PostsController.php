<?php

namespace SocialProBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SocialProBundle\Entity\Posts;
use SocialProBundle\Form\PostsType;
use Symfony\Component\HttpFoundation\File\UploadedFile ;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;


class PostsController extends Controller
{
    public function newsfeedAction(Request $request){
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $posts = new Posts();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostsType::class, $posts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $posts->getPostMedia();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $posts->setPostMedia($fileName);
            $posts->setUser($user);
            // ... persist the $posts variable or any other work
            $em->persist($posts);
            $em->flush();

        }
        $post = $em->getRepository("SocialProBundle:Posts")->findAllDescDQL();


        return $this->render('SocialProBundle:Newsfeed:show.html.twig',['user' => $user, 'p' => $post,
            'form' => $form->createView()]);
    }


    public function persoAction(Request $request)
    {
        $posts = new Posts();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostsType::class, $posts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $posts->getPostMedia();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $posts->setPostMedia($fileName);
            $posts->setUser($user);
            // ... persist the $posts variable or any other work
            $em->persist($posts);
            $em->flush();

            return $this->redirectToRoute('profile_post');
        }

        $post = $em->getRepository("SocialProBundle:Posts")->findAllDescDQL();

        return $this->render('SocialProBundle:Newsfeed:posts_perso.html.twig', array ('posts' => $post , 'user'=>$user, 'form' => $form->createView()));

    }

    public function modifierAction(Request $request, $id)
    {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository("SocialProBundle:Posts")->find($id);

        $Form = $this->createForm(PostsType::class, $post);
        $Form->handleRequest($request);

        if ($Form->isSubmitted() && $Form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $post->getPostMedia();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $post->setPostMedia($fileName);

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('profile_post');
        }
        return $this->render("SocialProBundle:Newsfeed:update.html.twig", array('posts' => $post ,'Form' => $Form->createView(),'user'=>$user));
    }

    public function signalerAction( $id)
    {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository("SocialProBundle:Posts")->find($id);

        $sg = $post->getPostSignal();
        $sg++;
        $post->setPostSignal($sg);

        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('social_pro_newsfeed');
    }


}
