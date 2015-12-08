<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class LiaisonSubjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
              'attr' => array(
                'class' => 'form-control'
              ),
              'label' => 'Subject Title',
              'label_attr' => array('class' => 'col-sm-2 control-label'),
            ))
            ->add('phone', null, array(
              'attr' => array(
                'class' => 'form-control'
              ),
              'label' => 'Phone Number',
              'label_attr' => array('class' => 'col-sm-2 control-label'),
            ))
            ->add('lft', 'hidden')
            ->add('lvl', 'hidden')
            ->add('rgt', 'hidden')
            ->add('parent', 'entity', array(
              'class'=>'AppBundle:LiaisonSubject',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('ls');
                  $qb
                    ->where('ls.lvl < 2') //only allow user to choose college or department
                    ->orderBy('ls.root, ls.lft', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle',
              'attr' => array(
                'class' => 'form-control'
              ),
              'label' => 'Parent Subject',
              'label_attr' => array('class' => 'col-sm-2 control-label'),
              'placeholder' => 'Choose Parent (leave blank if top-level college)',
              'required' => false
            ))
            ->add('primaryLiaison', 'entity', array(
              'class'=>'AppBundle:Staff',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('s');
                  $qb
                    ->where('s.employmentStatus = :status') //only allow user to choose parent
                    ->orderBy('s.lastName', 'ASC');
                  $qb->setParameter('status', 'faclib');
                  $qb->getQuery();
                  return $qb;
              },
              'attr' => array(
                'class' => 'form-control'
              ),
              'label' => 'Primary Liaison',
              'label_attr' => array('class' => 'col-sm-2 control-label'),
              'placeholder' => '--NOT SET--',
              'choice_label' => 'getFirstLastName', //getFirstLastName() method in Staff class
              'required' => false
            ))
            ->add('secondaryLiaison', 'entity', array(
              'class'=>'AppBundle:Staff',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('s');
                  $qb
                    ->where('s.employmentStatus = :status') //only allow user to choose parent
                    ->orderBy('s.lastName', 'ASC');
                  $qb->setParameter('status', 'faclib');
                  $qb->getQuery();
                  return $qb;
              },
              'attr' => array(
                'class' => 'form-control'
              ),
              'label' => 'Secondary Liaison',
              'label_attr' => array('class' => 'col-sm-2 control-label'),
              'placeholder' => '--NOT SET--',
              'choice_label' => 'getFirstLastName', //getFirstLastName() method in Staff class
              'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\LiaisonSubject'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_liaisonsubject';
    }
}
