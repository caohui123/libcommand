<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnualReportStaffingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', 'text', array(
                'label' => 'Staff Description',
                'label_attr' => array(
                    'class' => 'sr-only',
                ),
                'attr' => array(
                    'placeholder' => 'Description',
                )
            ))
            ->add('employeeCount', 'number', array(
                'label' => 'Quantity (use .5 for half)',
                'label_attr' => array(
                    'class' => 'sr-only',
                ),
                'attr' => array(
                    'placeholder' => 'Qty.',
                )
            ))
            ->add('isFullTime', 'checkbox', array(
                'label' => 'Full Time',
                'data' => true,
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AnnualReportStaffing'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_annualreportstaffing';
    }
}
