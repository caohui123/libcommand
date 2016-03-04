<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class FindTextType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('patronFirstName')
            ->add('patronLastName')
            ->add('patronEmail')
            ->add('comment')
        ;
        
        //Make sure the patronEmail field contains an emich email address!
        $emailValidator = function(FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the AvRequest entity is new (i.e. editing an existing Feedback)
            if(null === $request->getId()){
              $patronEmail = $form->get('patronEmail')->getData();

              $domain = explode('@', $patronEmail);
              if( $domain[1] != 'emich.edu' ){
                $form['patronEmail']->addError(new FormError("You are only allowed to enter an 'emich.edu' email addresses."));
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
            'data_class' => 'AppBundle\Entity\FindText',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_findtext';
    }
}
