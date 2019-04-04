<?php
/**
 * Created by PhpStorm.
 * User: bayrem
 * Date: 02/04/2017
 * Time: 22:10
 */

namespace SocialProBundle\Form;

use SocialProBundle\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use FOS\UserBundle\Util\LegacyFormHelper;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('postContent', TextareaType::class, array('label' => ' ', 'translation_domain' => 'SocialProBundle',
                'attr' => array('class' => 'form-control input-group-lg')))
            ->add('postMedia', FileType::class , array('label' => ' ' ,'data_class' => null))
            ->add('Publish', SubmitType::class, array( 'translation_domain' => 'SocialProBundle',
                'attr' => array('class' => 'btn btn-primary pull-right input-group-lg')))
            // ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Posts::class,
        ));
    }
}