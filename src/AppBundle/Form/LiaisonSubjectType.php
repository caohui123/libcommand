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
              'label' => 'Subject Title',
            ))
            ->add('phone', null, array(
              'label' => 'Phone Number',
              'required' => false
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
                    ->orderBy('ls.root, ls.lvl, ls.name', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle',
              'label' => 'Parent Subject',
              'placeholder' => 'No parent',
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
              'label' => 'Primary Liaison',
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
              'label' => 'Secondary Liaison',
              'placeholder' => '--NOT SET--',
              'choice_label' => 'getFirstLastName', //getFirstLastName() method in Staff class
              'required' => false
            ))
            ->add('facultyName', null, array(
              'label' => 'Faculty Liaison',
              'required' => false
            ))
            ->add('facultyPhone', null, array(
              'label' => 'Faculty Liaison Phone',
              'required' => false
            ))
            ->add('facultyOffice', null, array(
              'label' => 'Faculty Liaison Office',
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
