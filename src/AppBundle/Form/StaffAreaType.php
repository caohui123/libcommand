<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class StaffAreaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
              'label' => 'Title', 
              'label_attr' => array('class' => 'col-sm-2 control-label'),
              'attr' => array('class' => 'form-control')
            ))
            ->add('lft', 'hidden')
            ->add('lvl', 'hidden')
            ->add('rgt', 'hidden')
            ->add('root', 'hidden')
            ->add('parent', 'entity', array(
              'class'=>'AppBundle:StaffArea',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('sa');
                  $qb
                    ->where('sa.lvl < 1') //only allow user to choose parent
                    ->orderBy('sa.root, sa.lft', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle',
              'attr' => array(
                'class' => 'form-control'
              ),
              'label' => 'Parent Area',
              'label_attr' => array('class' => 'col-sm-2 control-label')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\StaffArea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_staffarea';
    }
}
