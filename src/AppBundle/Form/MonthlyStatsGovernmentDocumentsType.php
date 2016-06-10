<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonthlyStatsGovernmentDocumentsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemsAddedGross')
            ->add('itemsWithdrawn')
            ->add('itemsAddedNet')
            ->add('paper')
            ->add('electronicOpacUrls')
            ->add('weeklyRecordsAdded')
            ->add('monthlyRecordsAdded')
            ->add('monthlyNonOverlays')
            ->add('month')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MonthlyStatsGovernmentDocuments'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_monthlystatsgovernmentdocuments';
    }
}
