<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MaterialReserveItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('materialReserveMedia', null, array(
              'label'=>'Item Type',
              'placeholder'=>'Choose Media Type'
            ))
            ->add('title')
            ->add('author', null, array(
              'required' => false
            ))
            ->add('edition', null, array(
              'required' => false
            ))
            ->add('circulationHours', 'choice', array(
              'choices' => array(
                2 => '2 Hours',
                24 => '24 Hours',
                72 => '3 Days',
                168 => '7 Days'
              ),
              'expanded' => true,
              'multiple' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MaterialReserveItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_materialreserveitem';
    }
}
