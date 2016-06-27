<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonthlyStatsArchivesFileRequestedType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Title',
            ))
            ->add('type', 'choice', array(
                'choices' => array(
                    'biographical' => 'Biographical',
                    'photograph' => 'Photograph',
                    'subject' => 'Subject',
                ),
            ))
            ->add('quantity')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MonthlyStatsArchivesFileRequested'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_monthlystatsarchivesfilerequested';
    }
}
