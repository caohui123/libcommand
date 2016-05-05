<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Staff;

class GroupInstructionType extends AbstractType
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
            ->add('instructor')
            ->add('course')
            ->add('attendance')
            ->add('instructionDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy',
            ))
            ->add('startTime', 'time')
            ->add('endTime', 'time')
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
                'label' => 'Program'
            ))
            ->add('level', 'choice', array(
                'multiple' => false,
                'expanded' => true,
                'choices' => array(
                    '100-200' => '100-200',
                    '300-400' => '300-400',
                    'grad' => 'Graduate',
                    'high school' => 'High School',
                    'other' => 'Other'
                ),
            ))
            ->add('levelDescription', 'text', array(
                'required' => false,
                'label' => 'Level description (optional)'
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
            'data_class' => 'AppBundle\Entity\GroupInstruction',
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_groupinstruction';
    }
}
