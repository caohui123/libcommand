<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class FeedbackAreaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lft', 'hidden')
            ->add('lvl', 'hidden')
            ->add('rgt', 'hidden')
            ->add('parent', 'entity', array(
              'class'=>'AppBundle:FeedbackArea',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('fa');
                  $qb
                    ->where('fa.lvl < 1') //only allow user to choose parent
                    ->orderBy('fa.name', 'ASC')
                    ->getQuery();
                  return $qb;
              },
              'property' => 'indentedTitle',
              'label' => 'Parent Area',
              'placeholder' => 'No parent',
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
            'data_class' => 'AppBundle\Entity\FeedbackArea',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_feedbackarea';
    }
}
