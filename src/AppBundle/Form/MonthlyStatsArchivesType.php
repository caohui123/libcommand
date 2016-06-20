<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\DateTimeToStringTransformer;
use AppBundle\Form\AppBundle\Entity\MonthlyStatsArchivesCollectionType;

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
            ->add('researchMinutes5')
            ->add('researchMinutes10')
            ->add('researchMinutes15')
            ->add('researchMinutes20')
            ->add('researchMinutes30')
            ->add('researchMinutes45')
            ->add('researchMinutes60')
            ->add('instructionalMinutes5')
            ->add('instructionalMinutes10')
            ->add('instructionalMinutes15')
            ->add('instructionalMinutes20')
            ->add('instructionalMinutes30')
            ->add('instructionalMinutes45')
            ->add('instructionalMinutes60')
            ->add('researchersFaculty')
            ->add('researchersStaff')
            ->add('researchersUndergrad')
            ->add('researchersGrad')
            ->add('researchersCommunity')
            ->add('researchersOther')
            ->add('directionalEmailRef')
            ->add('directionalPhoneRef')
            ->add('researchRequestsCollectionEmailRef')
            ->add('researchRequestsCollectionPhoneRef')
            ->add('researchRequestsEmailRef')
            ->add('researchRequestsPhoneRef')
            ->add('donationsEmailRef')
            ->add('donationsPhoneRef')
            ->add('loansEmailRef')
            ->add('loansPhoneRef')
            ->add('holdingsAddedBooks')
            ->add('holdingsAddedFacultyPublications')
            ->add('accessionsLinearFeet')
            ->add('accessionsTotalCollections')
            ->add('month', 'hidden', array(
                'data' => $options['data']->getMonth(),
                'data_class' => null,
            ))
        ;
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
