<?php
/**
 * Created by PhpStorm.
 * User: bayrem
 * Date: 10/04/2017
 * Time: 06:16
 */

namespace SocialProBundle\Form;

use SocialProBundle\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('postSignal', TextType::class, array('label'=>' ','attr' => array('class' => 'form-control input-group-lg')))
            ->add('Search', SubmitType::class)
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