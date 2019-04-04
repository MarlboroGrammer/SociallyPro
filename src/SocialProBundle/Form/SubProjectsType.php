<?php

namespace SocialProBundle\Form;

use SocialProBundle\Controller\ProjectsController;
use SocialProBundle\Entity\SubProjectsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubProjectsType extends AbstractType
{
    private $Projects;
    /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $P=array($options['Project']);
        $builder->add('subProjectName',TextType::class,array('attr'=>array('class'=>'form-control')))->add('project',ChoiceType::class,array('choices'=>$P,'attr'=>array('class'=>'hidden form-control')))->add('team',EntityType::class,array('class'=>'SocialProBundle:Teams','choice_label'=>'teamName','attr'=>array('class'=>'form-control')))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialProBundle\Entity\SubProjects',
            'Project'=> null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'socialprobundle_subprojects';
    }


}
