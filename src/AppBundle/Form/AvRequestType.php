<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\AvRequestEventType;

class AvRequestType extends AbstractType
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
            
            //run only if the AvRequest entity already exists (i.e. editing an existing AvRequest)
            if($request && null !== $request->getId()){

            }
            
            //add in these fields only if the AvRequest is NEW
            if(!$request || null === $request->getId()){
              //AvRequestEvent entity collection
              $form->add('event', 'collection', array(
                'type' => new AvRequestEventType(),
                'allow_add' => true,
              ));
              
              $form->add('requestDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
              ));
              $form->add('deliverDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
              ));
              $form->add('returnDate', 'datetime', array(
                  'widget' => 'single_text',
                  'format' => 'yyyy-MM-dd HH:mm:ss',
              ));
            }  
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AvRequest',
            'csrf_protection' => false
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
