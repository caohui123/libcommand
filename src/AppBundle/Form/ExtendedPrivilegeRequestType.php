<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\ExtendedPrivilegeRequestStatus;

class ExtendedPrivilegeRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(\Symfony\Component\Form\FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the ExtendedPrivilegeRequest entity already exists (i.e. editing an existing AvRequest)
            if($request && null !== $request->getId()){
              $form->add('note');
              $form->add('status', 'entity', array(
                'class'=>'AppBundle:ExtendedPrivilegeRequestStatus',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('ep');
                    $qb
                      ->orderBy('ep.name', 'ASC')
                      ->getQuery();
                    return $qb;
                },
                'property' => 'getName',
                'placeholder' => '--NOT SET--',
                'preferred_choices' => function(ExtendedPrivilegeRequestStatus $status){
                  return 'other' !== strtolower($status->getName());
                }
              ));
            }
            
            //add in these fields only if the ExtendedPrivilegeRequest is NEW
            if(!$request || null === $request->getId()){
              
              $form->add('expirationDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
              ));
              $form->add('studentFirstName');
              $form->add('studentLastName');
              $form->add('studentPhone');
              $form->add('studentEmail');
              $form->add('studentEnumber');
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
              
              $studentEmail = $form->get('studentEmail')->getData();

              $domain = explode('@', $studentEmail);
              if( $domain[1] != 'emich.edu' ){
                $form['studentEmail']->addError(new FormError("You are only allowed to enter an 'emich.edu' email addresses."));
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
            'data_class' => 'AppBundle\Entity\ExtendedPrivilegeRequest',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_extendedprivilegerequest';
    }
}
