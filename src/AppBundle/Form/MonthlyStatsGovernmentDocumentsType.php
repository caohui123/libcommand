<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\DateTimeToStringTransformer;


class MonthlyStatsGovernmentDocumentsType extends AbstractType
{
    private $manager;
    
    public function __construct(ObjectManager $manager){
        $this->manager = $manager;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemsAddedGross')
            ->add('itemsWithdrawn')
            ->add('paper')
            ->add('electronicOpacUrls')
            ->add('weeklyRecordsAdded')
            ->add('monthlyRecordsAdded')
            ->add('monthlyNonOverlays')
            ->add('month', 'hidden', array(
                'data' => $options['data']->getMonth(),
                'data_class' => null,
            ))
        ;
        
        $builder->get('month')
                ->addModelTransformer(new DateTimeToStringTransformer($this->manager));
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
