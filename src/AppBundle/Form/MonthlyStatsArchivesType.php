<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\DateTimeToStringTransformer;
use AppBundle\Form\MonthlyStatsArchivesCollectionType;
use AppBundle\Form\MonthlyStatsArchivesBookQuantityType;
use AppBundle\Form\MonthlyStatsArchivesFileRequestedType;
use AppBundle\Form\MonthlyStatsArchivesFileDigitizationType;
use AppBundle\Form\MonthlyStatsArchivesCollectionProcessedType;
use AppBundle\Form\MonthlyStatsArchivesCollectionStoredType;

class MonthlyStatsArchivesType extends AbstractType
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
            //MonthlyStatsArchivesCollection entity collection
            ->add('requestedCollections', 'collection', array(
                'type' => new MonthlyStatsArchivesCollectionType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //MonthlyStatsArchivesCollection entity collection
            ->add('digitizationCollections', 'collection', array(
                'type' => new MonthlyStatsArchivesCollectionType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //MonthlyStatsArchivesBookQuantityType entity collection
            ->add('requestedBooks', 'collection', array(
                'type' => new MonthlyStatsArchivesBookQuantityType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //MonthlyStatsArchivesBookQuantityType entity collection
            ->add('digitizationBooks', 'collection', array(
                'type' => new MonthlyStatsArchivesBookQuantityType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //MonthlyStatsArchivesFileRequestedType entity collection
            ->add('requestedFiles', 'collection', array(
                'type' => new MonthlyStatsArchivesFileRequestedType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //MonthlyStatsArchivesFileDigitizationType entity collection
            ->add('digitizationFiles', 'collection', array(
                'type' => new MonthlyStatsArchivesFileDigitizationType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //MonthlyStatsArchivesCollectionProcessedType entity collection
            ->add('processedCollections', 'collection', array(
                'type' => new MonthlyStatsArchivesCollectionProcessedType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            //MonthlyStatsArchivesCollectionStoredType entity collection
            ->add('storedCollections', 'collection', array(
                'type' => new MonthlyStatsArchivesCollectionStoredType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('researchMinutes5', null, array(
                'attr' => array(
                    'class' => 'jscript_total research_minutes',
                    'min' => 0,
                ),
                'label' => '5 Minutes',
            ))
            ->add('researchMinutes10', null, array(
                'attr' => array(
                    'class' => 'jscript_total research_minutes',
                    'min' => 0,
                ),
                'label' => '10 Minutes',
            ))
            ->add('researchMinutes15', null, array(
                'attr' => array(
                    'class' => 'jscript_total research_minutes',
                    'min' => 0,
                ),
                'label' => '15 Minutes',
            ))
            ->add('researchMinutes20', null, array(
                'attr' => array(
                    'class' => 'jscript_total research_minutes',
                    'min' => 0,
                ),
                'label' => '20 Minutes',
            ))
            ->add('researchMinutes30', null, array(
                'attr' => array(
                    'class' => 'jscript_total research_minutes',
                    'min' => 0,
                ),
                'label' => '30 Minutes',
            ))
            ->add('researchMinutes45', null, array(
                'attr' => array(
                    'class' => 'jscript_total research_minutes',
                    'min' => 0,
                ),
                'label' => '45 Minutes',
            ))
            ->add('researchMinutes60', null, array(
                'attr' => array(
                    'class' => 'jscript_total research_minutes',
                    'min' => 0,
                ),
                'label' => '60 Minutes',
            ))
            ->add('instructionalMinutes5', null, array(
                'attr' => array(
                    'class' => 'jscript_total instructional_minutes',
                    'min' => 0,
                ),
                'label' => '5 Minutes',
            ))
            ->add('instructionalMinutes10', null, array(
                'attr' => array(
                    'class' => 'jscript_total instructional_minutes',
                    'min' => 0,
                ),
                'label' => '10 Minutes',
            ))
            ->add('instructionalMinutes15', null, array(
                'attr' => array(
                    'class' => 'jscript_total instructional_minutes',
                    'min' => 0,
                ),
                'label' => '15 Minutes',
            ))
            ->add('instructionalMinutes20', null, array(
                'attr' => array(
                    'class' => 'jscript_total instructional_minutes',
                    'min' => 0,
                ),
                'label' => '20 Minutes',
            ))
            ->add('instructionalMinutes30', null, array(
                'attr' => array(
                    'class' => 'jscript_total instructional_minutes',
                    'min' => 0,
                ),
                'label' => '30 Minutes',
            ))
            ->add('instructionalMinutes45', null, array(
                'attr' => array(
                    'class' => 'jscript_total instructional_minutes',
                    'min' => 0,
                ),
                'label' => '45 Minutes',
            ))
            ->add('instructionalMinutes60', null, array(
                'attr' => array(
                    'class' => 'jscript_total instructional_minutes',
                    'min' => 0,
                ),
                'label' => '60 Minutes',
            ))
            ->add('researchersFaculty', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Faculty',
            ))
            ->add('researchersStaff', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Staff',
            ))
            ->add('researchersUndergrad', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Undergraduate',
            ))
            ->add('researchersGrad', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Graduate',
            ))
            ->add('researchersCommunity', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Community',
            ))
            ->add('researchersOther', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Other',
            ))
            ->add('directionalEmailRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('directionalPhoneRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('researchRequestsCollectionEmailRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('researchRequestsCollectionPhoneRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('researchRequestsEmailRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('researchRequestsPhoneRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('donationsEmailRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('donationsPhoneRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('loansEmailRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('loansPhoneRef', null, array(
                'attr' => array(
                    'min' => 0,
                ),
            ))
            ->add('holdingsAddedBooks', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Books',
            ))
            ->add('holdingsAddedFacultyPublications', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Faculty Publications',
            ))
            ->add('accessionsLinearFeet', null, array(
                'attr' => array(
                    'step' => '0.1',
                    'type' => 'number',
                    'min' => 0,
                ),
                'label' => 'Linear Feet',
            ))
            ->add('accessionsTotalCollections', null, array(
                'attr' => array(
                    'min' => 0,
                ),
                'label' => 'Total Collections',
            ))
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
            'data_class' => 'AppBundle\Entity\MonthlyStatsArchives'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_monthlystatsarchives';
    }
}
