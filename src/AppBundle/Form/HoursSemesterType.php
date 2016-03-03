<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HoursSemesterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('season', 'choice', array(
                'choices'=> array(
                    0 => 'Winter',
                    1 => 'Spring',
                    2 => 'Summer',
                    3 => 'Fall'
                )
            ))
            ->add('year')
            ->add('startDate', null, array(
                'widget'=>'single_text',
            ))
            ->add('endDate', null, array(
                'widget'=>'single_text',
            ))
            ->add('chronOrder', 'hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\HoursSemester'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_hourssemester';
    }
}
