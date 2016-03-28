<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emergency', null, array(
                'label' => 'This is an alert or emergency bulletin.',
                'attr' => array(
                  'class' => 'user-status-ckbx-noajax'
                )
            ))
            ->add('emergencyLevel', 'choice', array(
                'choices' => array(
                    'Closure' => 'closure',
                    'Emergency' => 'emergency',
                    'Information' => 'info',
                    'Severe Weather' => 'weather',
                    'Other' => 'other'
                ),
                'preferred_choices' => array('closure', 'emergency', 'info', 'weather'),
                'choices_as_values' => true,
                'label' => 'Alert Type',
                'multiple' => false,
                'expanded' => true,
                'required' => false
            ))
            ->add('title')
            ->add('teaser', 'textarea', array(
              'label'=>'Teaser (100 character max)'
            ))
            ->add('body')
            ->add('delayedPost', 'checkbox', array(
                'label' => 'Set optional display date range.',
                'required' => false,
                'attr' => array(
                    'class' => 'user-status-ckbx-noajax'
                )
            ))
            ->add('displayStart', null, array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy HH:mm a',
                'label' => 'Begin Public Display',
                'required' => false
            ))
            ->add('displayEnd', null, array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy HH:mm a',
                'label' => 'Terminate Public Display (leave blank to display indefinitely)',
                'required' => false
            ))
            ->add('hidden', null, array(
              'label' => 'Hide this news story (overrides timed display settings).',
              'attr' => array(
                  'class' => 'user-status-ckbx-noajax'
              )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_news';
    }
}
