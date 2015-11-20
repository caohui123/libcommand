<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class StaffFunctionalAreaType extends AbstractType
{
    private $em;
    private $selectedDepartment; //the ID of the department to use as the default selection in the dropdown
    /**
     * Inject entity manager for querying
     */
    public function __construct($em, $selectedDepartment = null) {
      $this->em = $em;
      $this->selectedDepartment = $selectedDepartment;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('functionalArea', 'text', array('label' => 'Area Title', 'attr' => array('class'=>'form-control')))
            ->add('dept', 'entity', array(
              'class'=>'AppBundle:StaffDepartment',
              'choice_label'=>'department',
              'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('d')->orderBy('d.department', 'ASC');
              },
              'data'=>$this->em->getReference('AppBundle:StaffDepartment', $this->selectedDepartment),
              'label'=>'Parent Department',
              'attr'=>array('class' => 'form-control')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\StaffFunctionalArea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_stafffunctionalarea';
    }
}
