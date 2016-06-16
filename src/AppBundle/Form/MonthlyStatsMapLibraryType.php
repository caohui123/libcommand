<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\DateTimeToStringTransformer;

class MonthlyStatsMapLibraryType extends AbstractType
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
            ->add('mapsAddedGross', null, array(
                'label' => 'Maps added (gross)'
            ))
            ->add('mapsWithdrawn')
            ->add('materialsAddedGross', null, array(
                'label' => 'Uncataloged materials added (gross)'
            ))
            ->add('materialsWithdrawn', null, array(
                'label' => 'Uncataloged materials withdrawn'
            ))
            ->add('itemsShelved')
            ->add('itemsAdded')
            ->add('procedureQuestion1', null, array(
                'label' => '1 minute'
            ))
            ->add('procedureQuestion3', null, array(
                'label' => '3 minutes'
            ))
            ->add('procedureQuestion5', null, array(
                'label' => '5 minutes'
            ))
            ->add('procedureQuestion10', null, array(
                'label' => '10 minutes'
            ))
            ->add('procedureQuestion10Plus', null, array(
                'label' => '>10 minutes'
            ))
            ->add('researchQuestion1', null, array(
                'label' => '1 minute'
            ))
            ->add('researchQuestion3', null, array(
                'label' => '3 minutes'
            ))
            ->add('researchQuestion5', null, array(
                'label' => '5 minutes'
            ))
            ->add('researchQuestion10', null, array(
                'label' => '10 minutes'
            ))
            ->add('researchQuestion15', null, array(
                'label' => '15 minutes'
            ))
            ->add('researchQuestion20', null, array(
                'label' => '20 minutes'
            ))
            ->add('researchQuestion25', null, array(
                'label' => '25 minutes'
            ))
            ->add('researchQuestion25Plus', null, array(
                'label' => '>25 minutes'
            ))
            ->add('month', 'hidden', array(
                'data' => $options['data']->getMonth(),
                'data_class' => null,
            ))
        ;
        
        //Takes the AnnualReportUnit id passed to the unit field and converts it into the proper AnnualReportUnit entity.
        $builder->get('month')
                ->addModelTransformer(new DateTimeToStringTransformer($this->manager));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MonthlyStatsMapLibrary'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_monthlystatsmaplibrary';
    }
}
