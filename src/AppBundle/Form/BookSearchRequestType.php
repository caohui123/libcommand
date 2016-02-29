<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class BookSearchRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bookTitle')
            ->add('bookAuthor')
            ->add('bookCallNumber')
        ;
        
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(\Symfony\Component\Form\FormEvent $event){
            $request = $event->getData();
            $form = $event->getForm();
            
            //run only if the BookSearchRequest entity already exists (i.e. editing an existing BookSearchRequest)
            if($request && null !== $request->getId()){
                $form->add('bookStatus', 'choice', array(
                  'label' => 'Book Status',
                  'expanded' => true,
                  'multiple' => false,
                  'choices' => array(
                    'none' => 'none',
                    'found' => 'Found',
                    'missing' => 'Missing',
                    'charged' => 'Charged',
                  ),
                ));
                $form->add('note');
            }
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BookSearchRequest',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_booksearchrequest';
    }
}
