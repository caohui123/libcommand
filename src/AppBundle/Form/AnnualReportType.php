<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\AnnualReportStaffingType;
use AppBundle\Form\AnnualReportDetailType;

class AnnualReportType extends AbstractType
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
        // AnnualReport object passed into $options['data'] array
        $builder
            //AnnualReportStaffing entity collection
            ->add('staffingTenured', 'collection', array(
                'type' => new AnnualReportStaffingType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportStaffing entity collection
            ->add('staffingClerical', 'collection', array(
                'type' => new AnnualReportStaffingType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportStaffing entity collection
            ->add('staffingLecturers', 'collection', array(
                'type' => new AnnualReportStaffingType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportStaffing entity collection
            ->add('staffingOther', 'collection', array(
                'type' => new AnnualReportStaffingType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportDetail entity collection
            ->add('detailCore', 'collection', array(
                'type' => new AnnualReportDetailType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportDetail entity collection
            ->add('detailProgress', 'collection', array(
                'type' => new AnnualReportDetailType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportDetail entity collection
            ->add('detailInitiatives', 'collection', array(
                'type' => new AnnualReportDetailType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportDetail entity collection
            ->add('detailAccomplishments', 'collection', array(
                'type' => new AnnualReportDetailType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportDetail entity collection
            ->add('detailChanges', 'collection', array(
                'type' => new AnnualReportDetailType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //AnnualReportDetail entity collection
            ->add('detailObjectives', 'collection', array(
                'type' => new AnnualReportDetailType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('year', 'hidden', array(
                'data' => $options['data']->getYear(),
            ))
            ->add('unit', 'hidden', array(
                'data' => $options['data']->getUnit(),
                'data_class' => null,
            ))
            ->add('isFinal', 'checkbox', array(
                'label'=> 'Mark as Final ', 
                'required'=>false, 
                'attr'=>array('class'=>'user-status-ckbx-noajax')
            ))
        ;
        //Takes the AnnualReportUnit id passed to the unit field and converts it into the proper AnnualReportUnit entity.
        $builder->get('unit')
                ->addModelTransformer(new DataTransformer\AnnualReportUnitToIntTransformer($this->manager));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AnnualReport'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_annualreport';
    }
}
