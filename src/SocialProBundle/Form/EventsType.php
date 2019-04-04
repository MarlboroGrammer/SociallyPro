<?php

namespace SocialProBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class EventsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventName',TextType::class,array('attr'=> array('class'=>'form-control')))
            ->add('eventType',ChoiceType::class, array('choices' => array('Social' => 'Social','Professional'=>'Professional' ),'attr'=> array('class'=>'form-control')))
            ->add('eventDate',DateType::class,array('attr'=> array('class'=>'datepicker form-control'),'widget'=>'single_text'))
            ->add('eventAddress',TextType::class,array('attr'=> array('class'=>'form-control')))
            ->add('eventDescription',TextareaType::class,array('attr'=> array('class'=>'form-control')))
            ->add('rating', RatingType::class, ['label' => 'Rating']);
        //->add('eventMedia',TextType::class,array('attr'=> array('class'=>'form-control')))
            //->add('state',TextType::class,array('attr'=> array('class'=>'form-control'),'disabled'=>'true'));
            //->add('idEmployee',TextType::class,array('attr'=> array('class'=>'form-control')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialProBundle\Entity\Events'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'socialprobundle_events';
    }


}
