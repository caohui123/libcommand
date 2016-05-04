<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Staff;

class IndividualInstructionType extends AbstractType
{
    private $manager;
    private $staff; 
    
    public function __construct(ObjectManager $manager, Staff $staff = null){
        $this->manager = $manager;
        $this->staff = $staff;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('librarian', 'entity', array(
                'class' => 'AppBundle:Staff',
                'query_builder' => function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('st');
                    $qb
                        ->where('st.id = :staffId')
                        ->setParameter('staffId', $this->staff)
                        ->getQuery();
                    return $qb;
                },
            ))
            ->add('client')
            ->add('course')
            ->add('instructionDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy',
            ))
            ->add('startTime', 'time')
            ->add('endTime', 'time')
            ->add('level', 'choice', array(
                'multiple' => false,
                'expanded' => true,
                'choices' => array(
                    'undergrad' => 'Undergraduate',
                    'grad' => 'Graduate',
                    'staff' => 'Staff',
                    'faculty' => 'Faculty',
                    'other' => 'Other'
                ),
                'label' => 'Academic Status'
            ))
            ->add('levelDescription', 'text', array(
                'required' => false,
                'label' => 'Expanded description of academic status (optional)'
            ))
            ->add('interaction', 'choice', array(
                'multiple' => false,
                'expanded' => true,
                'choices' => array(
                    'person' => 'In Person',
                    'online' => 'Online',
                    'phone' => 'Phone',
                ),
            ))
            ->add('note', null, array(
                'required' => false
            ))
        ;
                
        $builder->get('librarian')
                ->addModelTransformer(new DataTransformer\StaffToIntTransformer($this->manager));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\IndividualInstruction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_individualinstruction';
    }
}
