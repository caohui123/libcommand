<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityRepository;

class MaterialPurchaseRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('isbn')
            ->add('issn')
            ->add('author')
            ->add('publisher')
            ->add('publicationYear')
            ->add('edition')
            ->add('price')
            ->add('isInCatalog')
        ;
        
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the AvRequest entity already exists (i.e. editing an existing AvRequest)
            if($request && null !== $request->getId()){
              $form->add('status', 'entity', array(
                'class'=>'AppBundle:MaterialPurchaseRequestStatus',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('st');
                    $qb
                      ->orderBy('st.name', 'ASC')
                      ->getQuery();
                    return $qb;
                },
                'placeholder' => 'New Request',
                'required' => false
              ));
                
              $form->add('note', null, array(
                'required' => false
              ));
            }
            
            //add in these fields only if the AvRequest is NEW
            if(!$request || null === $request->getId()){
              $form->add('patronFirstName');
              $form->add('patronLastName');
              $form->add('patronEmail');
              $form->add('patronGroup', 'entity', array(
                'class'=>'AppBundle:PatronGroup',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('pg');
                    $qb
                      ->orderBy('pg.name', 'ASC')
                      ->getQuery();
                    return $qb;
                },
                'expanded' => true,
                'multiple' => false
              ));
              $form->add('notify', null, array(
                'label' => 'Notify me when the book is in the library.',
              ));
              $form->add('mediaType', 'entity', array(
                'class'=>'AppBundle:MediaType',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('mt');
                    $qb
                      ->orderBy('mt.name', 'ASC')
                      ->getQuery();
                    return $qb;
                },
                'placeholder' => 'Choose Type',
              ));
              $form->add('patronDepartment', 'entity', array(
                'class'=>'AppBundle:LiaisonSubject',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('ls');
                    $qb
                      ->where('ls.lvl = 1')
                      ->orderBy('ls.root, ls.lvl, ls.name', 'ASC')
                      ->getQuery();
                    return $qb;
                },
                'placeholder' => 'Not Sure/Other',
                'required' => false
              ));
              $form->add('reasonToAdd', 'entity', array(
                'class'=>'AppBundle:MaterialPurchaseRequestReason',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('mpr');
                    $qb
                      ->getQuery();
                    return $qb;
                },
                'expanded' => true,
                'multiple' => false
              ));
              $form->add('reasonToAddExplain');
              $form->add('sourceRadio', 'choice', array(
                'mapped' => false,
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                  'worldcat' => 'WorldCat',
                  'publishercatalog' => 'Publisher\'s Catalog',
                  'review' => 'Review',
                  'other' => 'Other'
                )
              ));
              $form->add('sourceOther', 'text', array(
                'mapped' => false,
                'label' => 'Other Reason',
                'required' => false
              ));
            }  
        });
        /*
        //Make sure the facultyEmail field contains an emich email address!
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
        $builder->addEventListener(FormEvents::POST_BIND, $emailValidator);*/
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MaterialPurchaseRequest',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_materialpurchaserequest';
    }
}
