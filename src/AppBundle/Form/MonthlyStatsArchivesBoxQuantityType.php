<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MonthlyStatsArchivesBoxQuantityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('box', 'entity', array(
                'label' => 'Box Number',
                'class'=>'AppBundle:MonthlyStatsArchivesBox',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('b');
                    $qb
                      ->orderBy('b.boxNumber', 'ASC')
                      ->getQuery();
                    return $qb;
                },
                'placeholder' => '--NOT SET--',
            ))
            ->add('quantity')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MonthlyStatsArchivesBoxQuantity'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_monthlystatsarchivesboxquantity';
    }
}
