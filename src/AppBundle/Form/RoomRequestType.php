<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class RoomRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
        ;
                
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
        
            //run only if the RoomRequest entity already exists (i.e. editing an existing RoomRequest)
            if($request && null !== $request->getId()){
                $form->add('note');
            }
            
            //add in these fields only if the RoomRequest is NEW
            if(!$request || null === $request->getId()){
                $form->add('reserveDate', null, array(
                    'widget' => 'single_text'
                ));
                $form->add('startTime', null, array(
                    'widget' => 'single_text'
                ));
                $form->add('endTime', null, array(
                    'widget' => 'single_text'
                ));
                $form->add('facultyFirstName');
                $form->add('facultyLastName');
                $form->add('facultySubject', 'entity', array(
                    'class'=>'AppBundle:LiaisonSubject',
                    'query_builder'=>function(EntityRepository $er){
                        $qb = $er->createQueryBuilder('ls');
                        $qb
                          ->orderBy('ls.root, ls.lvl, ls.name', 'ASC')
                          ->getQuery();
                        return $qb;
                    },
                    'property' => 'indentedTitle',
                    'placeholder' => 'Not Sure/Other',
                    'required' => false
                ));
                $form->add('event');
                $form->add('attendees');
                $form->add('facultyPhone');
                $form->add('facultyEmail');
                $form->add('isTrainingNeeded');
                $form->add('otherDetails');
                $form->add('room', 'entity', array(
                    'class' => 'AppBundle:RoomRequestRoom',
                    'multiple' => false,
                    'expanded' => true,
                ));
                $form->add('fixedEquipment', 'entity', array(
                    'class' => 'AppBundle:RoomRequestEquipment',
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder'=>function(EntityRepository $er){
                        $qb = $er->createQueryBuilder('re');
                        $qb
                          ->where('re.isMobile = 0')
                          ->orderBy('re.name', 'ASC')
                          ->getQuery();
                        return $qb;
                    },
                    'mapped' => false, //fixed and mobile equipment will be added to equipment array on save
                ));
                $form->add('mobileEquipment', 'entity', array(
                    'class' => 'AppBundle:RoomRequestEquipment',
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder'=>function(EntityRepository $er){
                        $qb = $er->createQueryBuilder('re');
                        $qb
                          ->where('re.isMobile = 1')
                          ->orderBy('re.name', 'ASC')
                          ->getQuery();
                        return $qb;
                    },
                    'mapped' => false, //fixed and mobile equipment will be added to equipment array on save
                ));
            }
        });
                
        //Make sure the facultyEmail field contains an emich email address!
        $emailValidator = function(FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the AvRequest entity is new (i.e. editing an existing Feedback)
            if(null === $request->getId()){
              $facultyEmail = $form->get('facultyEmail')->getData();

              $domain = explode('@', $facultyEmail);
              if( $domain[1] != 'emich.edu' ){
                $form['facultyEmail']->addError(new FormError("You are only allowed to enter an 'emich.edu' email addresses."));
              }
            }
        };
        $builder->addEventListener(FormEvents::POST_BIND, $emailValidator);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RoomRequest',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_roomrequest';
    }
}
