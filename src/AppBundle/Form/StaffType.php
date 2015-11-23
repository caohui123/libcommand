<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class StaffType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('staffId')
            ->add('employmentStatus')
            ->add('firstName')
            ->add('lastName')
            ->add('jobTitle')
            ->add('guidesUrl')
            ->add('office')
            ->add('phone')
            ->add('email')
            ->add('jobDescription')
            ->add('homeStreet')
            ->add('homeZip')
            ->add('homePhone')
            ->add('cellPhone')
            ->add('selfIntro')
            ->add('favoriteWebsites')
            ->add('photo', 'file')
            ->add('showPhoto', 'checkbox', array('label' => 'Show photo on public website? '))
            //->add('created')
            //->add('updated')
            ->add('staffFunctionalArea', 'entity', array(
              'class'=>'AppBundle:StaffFunctionalArea',
              'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('f')->orderBy('f.functionalArea', 'ASC');
              },
              'data'=>null,
              'label'=>'Functional Unit',
              'attr'=>array('class' => 'form-control'),
              'placeholder' => 'No associated unit',
              'required'=>false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Staff'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_staff';
    }
}
