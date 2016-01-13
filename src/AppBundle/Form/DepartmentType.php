<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DepartmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('room')
            ->add('phone')
            ->add('fax')
            ->add('description')
            ->add('lft', 'hidden')
            ->add('lvl', 'hidden')
            ->add('rgt', 'hidden')
            ->add('parent', 'entity', array(
              'class'=>'AppBundle:Department',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('d');
                  $qb
                    ->where('d.lvl < 1') //only allow user to choose parent
                    ->orderBy('d.root, d.lft', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle',
              'label' => 'Parent Department',
              'placeholder' => 'Choose Parent (leave blank if parent)',
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
            'data_class' => 'AppBundle\Entity\Department'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_department';
    }
}
