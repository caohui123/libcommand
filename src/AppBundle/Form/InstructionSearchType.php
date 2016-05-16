<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Resources\Services\InstructionService;

class InstructionSearchType extends AbstractType
{    
    private $instruction_service;
    
    // Need to use a function from the instruction service, so pass it in from the calling controller.
    public function __construct(InstructionService $instruction_service) {
        $this->instruction_service = $instruction_service;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $criteria = array('instructionType' => $options['data']['instructionType'], 'filterCriteria' => $options['data']['filterCriteria']);
        
        $builder    
            ->add('librarian', 'entity', array(
                'class' => 'AppBundle:Staff',
                'query_builder' => function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('st');
                    $qb
                        ->where('st.employmentStatus = :employmentStatus')
                        ->setParameter('employmentStatus', 'faclib')
                        ->orderBy('st.lastName', 'DESC')
                        ->getQuery();
                    return $qb;
                },
                'placeholder' => 'All Librarians',
                'required' => false
            ))
            ->add('program', 'entity', array(
                'class' => 'AppBundle:LiaisonSubject',
                'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('ls');
                  $qb
                    ->orderBy('ls.root, ls.lvl, ls.name', 'ASC')
                    ->getQuery();
                  return $qb;
                },
                'property' => 'indentedTitle',
                'placeholder' => 'All Programs',
                'label' => 'Program',
                'required' => false,
            ))
            //pass along the instruction type and filter criteria strings for processing
            ->add('instructionType', 'hidden', array(
                'data' => $criteria['instructionType']
            ))
            ->add('filterCriteria', 'hidden', array(
                'data' => $criteria['filterCriteria']
            ))
            ;
            
            // Reads the criteria variable passed into the form (declared above) to add additional fields
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($criteria){
                $form = $event->getForm();

                if($criteria['filterCriteria'] == 'fiscal'){
                    $form->add('fiscalYear', 'choice', array(
                        'choices' => $this->instruction_service->generateYears(),
                        'label' => 'Fiscal Year (Jul-Jun)',
                    ));
                }
                
                if($criteria['filterCriteria'] == 'academic'){
                    $form->add('academicYear', 'choice', array(
                        'choices' => $this->instruction_service->generateYears(),
                        'label' => 'Academic Year (Sept-Aug)',
                    ));
                }
                
                if($criteria['filterCriteria'] == 'calendar'){
                    $form->add('calendarYear', 'choice', array(
                        'choices' => $this->instruction_service->generateYears(false),
                        'label' => 'Calendar Year',
                    ));
                }
                
                if($criteria['filterCriteria'] == 'semester'){
                    $form->add('semester', 'choice', array(
                        'choices' => array(
                            'winter' => 'Winter',
                            'spring' => 'Spring',
                            'summer' => 'Summer',
                            'fall' => 'Fall',
                        ),
                    ));       
                    $form->add('year', 'choice', array(
                        'choices' => $this->instruction_service->generateYears(false),
                    ));
                }
                
                if($criteria['filterCriteria'] == 'custom'){
                    $form->add('startDate', 'date', array(
                        'html5' => false,
                        'widget' => 'single_text',
                        'format' => 'MM/dd/yyyy',
                        'label' => 'From'
                    ));
                    $form->add('endDate', 'date', array(
                        'html5' => false,
                        'widget' => 'single_text',
                        'format' => 'MM/dd/yyyy',
                        'label' => 'To',
                        'required' => false,
                    ));
                }
                
                if($criteria['instructionType'] == 'group'){
                    $form->add('level', 'choice', array(
                        'multiple' => false,
                        'expanded' => true,
                        'choices' => array(
                            '100-200' => '100-200',
                            '300-400' => '300-400',
                            'grad' => 'Graduate',
                            'high school' => 'High School',
                            'other' => 'Other'
                        ),
                        'required' => false,
                    ));
                }
                if($criteria['instructionType'] == 'individual'){
                    $form->add('level', 'choice', array(
                        'multiple' => false,
                        'expanded' => true,
                        'choices' => array(
                            'undergrad' => 'Undergraduate',
                            'grad' => 'Graduate',
                            'staff' => 'Staff',
                            'faculty' => 'Faculty',
                            'other' => 'Other'
                        ),
                        'label' => 'Academic Status',
                        'required' => false,
                    ));
                }
            });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'instrsearch';
    }
}
