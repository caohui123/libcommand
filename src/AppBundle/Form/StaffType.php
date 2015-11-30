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
            ->add('employmentStatus', 'choice', array(
              'choices' => array(
                'Faculty (librarian)' => 'faclib',
                'Faculty (non-librarian)' => 'facnolib',
                'Staff' => 'staff',
                'Student' => 'student',
                'Temporary' => 'temp',
                'Inactive' => 'inactive',
                'Retired' => 'retired'
              ),
              'choices_as_values' => true,
              'preferred_choices' => array('faclib', 'facnolib', 'staff', 'student', 'temp')
            ))
            ->add('firstName')
            ->add('lastName')
            ->add('jobTitle')
            ->add('guidesUrl', null, array('required'=>false))
            ->add('office')
            ->add('phone')
            ->add('email')
            ->add('jobDescription', null, array('required'=>false))
            ->add('homeStreet', null, array('required'=>false))
            ->add('homeCity', null, array('required'=>false))
            ->add('homeState', null, array('required'=>false))
            ->add('homeZip', null, array('required'=>false))
            ->add('homePhone', null, array('required'=>false))
            ->add('cellPhone', null, array('required'=>false))
            ->add('selfIntro', null, array('required'=>false))
            ->add('favoriteWebsites', null, array('required'=>false))
            ->add('photo', 'file', array('required'=>false))
            ->add('showPhoto', 'checkbox', array('label' => 'Show photo on public website? ', 'required'=>false))
            ->add('staffFunctionalArea', 'entity', array(
              'class'=>'AppBundle:StaffArea',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('sa');
                  $qb
                    ->where('sa.lvl < 2')
                    ->orderBy('sa.root, sa.lft', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle',
              'attr' => array(
                'class' => 'form-control'
              ),
              'label' => 'Functional Area',
              'label_attr' => array('class' => 'col-sm-2 control-label'),
              'placeholder' => '--Choose a Functional Area--',
              'required' => true
            ));
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
