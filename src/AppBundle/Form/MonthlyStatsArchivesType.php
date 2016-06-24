<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\DateTimeToStringTransformer;
use AppBundle\Form\MonthlyStatsArchivesCollectionType;
use AppBundle\Form\MonthlyStatsArchivesBookQuantityType;

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
            ->add('researchMinutes5', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchMinutes10', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchMinutes15', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchMinutes20', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchMinutes30', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchMinutes45', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchMinutes60', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('instructionalMinutes5', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('instructionalMinutes10', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('instructionalMinutes15', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('instructionalMinutes20', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('instructionalMinutes30', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('instructionalMinutes45', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('instructionalMinutes60', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchersFaculty', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchersStaff', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchersUndergrad', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchersGrad', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchersCommunity', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchersOther', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('directionalEmailRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('directionalPhoneRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchRequestsCollectionEmailRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchRequestsCollectionPhoneRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchRequestsEmailRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('researchRequestsPhoneRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('donationsEmailRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('donationsPhoneRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('loansEmailRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('loansPhoneRef', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('holdingsAddedBooks', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('holdingsAddedFacultyPublications', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('accessionsLinearFeet', null, array(
                'required' => false,
                'data' => 0,
            ))
            ->add('accessionsTotalCollections', null, array(
                'required' => false,
                'data' => 0,
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
