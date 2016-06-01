<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
            ->add('year', 'hidden', array(
                'data' => $options['data']->getYear(),
            ))
            ->add('unit', 'hidden', array(
                'data' => $options['data']->getUnit(),
                'data_class' => null,
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
