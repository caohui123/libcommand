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
            ->add('level')
            ->add('note')
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
