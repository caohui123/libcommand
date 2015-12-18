<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HoursRegularType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('openTime', null, array(
                'label'=>'Open', 
                'widget'=>'single_text',
                'html5' => false  //input type="text" instead of "time"
            ))
            ->add('closeTime', null, array(
                'label'=>'Close', 
                'widget'=>'single_text',
                'html5' => false //input type="text" instead of "time"
            ))
            ->add('status', 'choice', array(
                'label'=>'Status',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    0 => 'Normal',
                    1 => '24 Hours',
                    2 => 'Closed'
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
            'data_class' => 'AppBundle\Entity\HoursRegular',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_hoursregular';
    }
}

