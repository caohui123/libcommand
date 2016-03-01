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
              'label' => 'Functional Area',
              'placeholder' => '--Choose a Functional Area--',
              'required' => true
            ))
            ->add('department', 'entity', array(
              'class'=>'AppBundle:Department',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('d');
                  $qb
                    ->orderBy('d.root, d.lft', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle', //method to display the name of the dept.
              'label' => 'Library Department',
              'placeholder' => '--Choose a Department--',
              'required' => false
            ))
            ->add('photo', 'file', array(
              'required' => false,
              'data_class' => null,
              'label' => 'New Photo'
            ))
            ->add('showPhoto', 'checkbox', array('label' => 'Show photo on public website? ', 'required'=>false));
              
          
         //add in these fields only if the HoursSpecial object is new using an event listener
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(\Symfony\Component\Form\FormEvent $event){
            $staff = $event->getData();
            $form = $event->getForm();
            
            // check for the exsitence of a current photo path
            // If no path is passed to the form, the data is "null".
            // There should be no delete button present if there is no photo path present
            if(!$staff || null !== $staff->getPhoto()){
                $form->add('deletePhotoSubmit', 'submit', array('label'=>'Delete Photo', 'attr' => array('class' => 'btn btn-sm btn-warning')));
            }
        });
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
