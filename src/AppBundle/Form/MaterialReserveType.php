<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\AvRequestEquipmentQuantityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use AppBundle\Form\MaterialReserveItemType;

class MaterialReserveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('semester')
            ->add('year')
            ->add('course')
            ->add('enrollment')
            ->add('phone')
        ;
        
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the MaterialReserve entity already exists (i.e. editing an existing MaterialReserve)
            if($request && null !== $request->getId()){

            }
            
            //add in these fields only if the MaterialReserve is NEW
            if(!$request || null === $request->getId()){
              $form->add('email');
              $form->add('instructor');
              
              //MaterialReserveItem entity collection
              //tutorial: http://symfony.com/doc/2.7/cookbook/form/form_collections.html
              $form->add('item', 'collection', array(
                'type' => new MaterialReserveItemType(),
                'allow_add' => true,
                'by_reference' => false,
              ));
            }      
        });
        
        //Make sure the facultyEmail field contains an emich email address!
        $emailValidator = function(FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the AvRequest entity is new (i.e. editing an existing Feedback)
            if(null === $request->getId()){
              $email = $form->get('email')->getData();

              $domain = explode('@', $email);
              if( $domain[1] != 'emich.edu' ){
                $form['email']->addError(new FormError("You are only allowed to enter an 'emich.edu' email addresses."));
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
            'data_class' => 'AppBundle\Entity\MaterialReserve'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_materialreserve';
    }
}
