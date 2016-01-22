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
            ))
            ->add('lft', 'hidden')
            ->add('lvl', 'hidden')
            ->add('rgt', 'hidden')
            //->add('root', 'hidden') #leave out...will throw error "Root cannot be changed manually, change parent instead"
            ->add('parent', 'entity', array(
              'class'=>'AppBundle:StaffArea',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('sa');
                  $qb
                    ->where('sa.lvl < 1') //only allow user to choose parent
                    ->orderBy('sa.title', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle',
              'label' => 'Parent Area',
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
