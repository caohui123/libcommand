<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\AvRequestEventType;
use AppBundle\Form\AvRequestEquipmentQuantityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class AvRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder;
        
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the AvRequest entity already exists (i.e. editing an existing AvRequest)
            if($request && null !== $request->getId()){

            }
            
            //add in these fields only if the AvRequest is NEW
            if(!$request || null === $request->getId()){
              
              $form->add('eventDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
              ));
              $form->add('pickupDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
              ));
              $form->add('returnDate', 'date', array(
                  'widget' => 'single_text',
                  'format' => 'yyyy-MM-dd HH:mm:ss',
              ));
              //AvRequestEvent entity collection
              //tutorial: http://symfony.com/doc/2.7/cookbook/form/form_collections.html
              $form->add('event', 'collection', array(
                'type' => new AvRequestEventType(),
                'allow_add' => true,
                'by_reference' => false,
              ));
              //AvRequestEquipment entity collection
              $form->add('equipment', 'collection', array(
                'type' => new AvRequestEquipmentQuantityType(),
                'allow_add' => true,
                'by_reference' => false,
              ));
              $form->add('facultyFirstName');
              $form->add('facultyLastName');
              $form->add('facultyPhone');
              $form->add('facultyEmail');
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
              $form->add('course', null, array(
                'label' => 'Course or Event'
              ));
              $form->add('attendees');
              $form->add('studentName');
              $form->add('studentEnumber');
              $form->add('specialInstruction', 'textarea', array(
                'label' => 'Special Instructions'
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
            'data_class' => 'AppBundle\Entity\AvRequest',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_avrequest';
    }
}
