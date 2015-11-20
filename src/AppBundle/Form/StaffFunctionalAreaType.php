<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StaffFunctionalAreaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('functionalArea')
            ->add('department', 'choice', array(
              'choices' => array(1 => 'Something', 2 => 'Something Else')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\StaffFunctionalArea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_stafffunctionalarea';
    }
}
