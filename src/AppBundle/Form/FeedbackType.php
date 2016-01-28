<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class FeedbackType extends AbstractType
{
    private $manager;
    
    //use this constructor for all 'edit' forms
    function __construct(ObjectManager $manager = null) {
      $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', null, array(
              'label' => 'Edit Feedback Type',
              'placeholder' => 'NOT SET (required)',
            ))
            ->add('patronGroup', null, array(
              'label' => 'Edit Patron Group',
              'placeholder' => 'NOT SET (required)',
            ))
        ;
        
        
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(\Symfony\Component\Form\FormEvent $event){
            $feedback = $event->getData();
            $form = $event->getForm();
            
            //run only if the Feedback entity already exists (i.e. editing an existing Feedback)
            if($feedback && null !== $feedback->getId()){
                $form->add('forwardedTo', 'text', array(
                  'mapped' => false, //this field is NOT mapped to the entity
                  'required' => false,
                  'label' => 'Forward this feedback (emich address only)'
                ));
                $form->add('forwardedMessage', 'textarea', array(
                  'mapped' => false, //this field is NOT mapped to the entity
                  'required' => false,
                  'label' => 'Optional forawrd message (not sent to patron)'
                ));
                $form->add('note', 'textarea', array(
                  'required' => false,
                  'label' => 'Note about this feedback (will NOT be sent to patron)'
                ));
                $form->add('areas', 'entity', array(
                  'class'=>'AppBundle:FeedbackArea',
                  'query_builder'=>function(EntityRepository $er){
                      $qb = $er->createQueryBuilder('fa');
                      $qb
                        ->where('fa.lvl < 2') //only allow user to choose parent or one level of children
                        ->orderBy('fa.root, fa.lvl, fa.name', 'ASC')
                        ->getQuery();
                      return $qb;
                  },
                  'property' => 'indentedTitle',
                  'label' => 'Categories (select all that apply)',
                  'multiple'=>true,
                  'required' => false
                ));
                  
                //provide an area to reply to the patron ONLY IF it hasn't been done already
                if(null === $feedback->getResponse()){
                  $form->add('reply', 'textarea', array(
                    'mapped' => false, //this field is NOT mapped to the entity
                    'required' => false,
                    'label' => 'Response to Patron'
                  ));
                }
            }
            
            //add in these fields only if the Feedback is NEW
            if(!$feedback && null === $feedback->getId()){
              $form->add('body', null, array(
                'label' => 'Your feedback'
              ));
              $form->add('patronEmail');
              $form->add('patronFirstName', null, array(
                'required' => false
              ));
              $form->add('patronLastName', null, array(
                'required' => false
              ));
              $form->add('patronPhone', null, array(
                'required' => false
              ));
            }  
        });
        
        //Make sure if there is a message being forwarded that the forwardedTo field contains an emich email address!
        $forwardValidator = function(FormEvent $event){
            $feedback = $event->getData();
            $form = $event->getForm();
            
            //run only if the Feedback entity already exists (i.e. editing an existing Feedback)
            if($feedback && null !== $feedback->getId()){
              $forwardedMessage = $form->get('forwardedMessage')->getData();
              $forwardedTo = $form->get('forwardedTo')->getData();

              if ( !empty($forwardedTo) && !filter_var($forwardedTo, FILTER_VALIDATE_EMAIL) ) {
                $form['forwardedTo']->addError(new FormError("Please specify a valid email address for forwarding."));
              } else if (!empty($forwardedTo) && filter_var($forwardedTo, FILTER_VALIDATE_EMAIL)){
                $domain = explode('@', $forwardedTo);
                if( $domain[1] != 'emich.edu' ){
                  $form['forwardedTo']->addError(new FormError("You are only allowed to forward to 'emich.edu' email addresses."));
                }
              }
            }
        };
        $builder->addEventListener(FormEvents::POST_BIND, $forwardValidator);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Feedback',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_feedback';
    }
}
