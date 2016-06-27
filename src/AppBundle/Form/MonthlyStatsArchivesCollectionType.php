<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\MonthlyStatsArchivesBoxQuantityType;

class MonthlyStatsArchivesCollectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'entity', array(
                'class'=>'AppBundle:MonthlyStatsArchivesCollectionTitle',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('c');
                    $qb
                      ->orderBy('c.name', 'ASC')
                      ->getQuery();
                    return $qb;
                },
                'placeholder' => '--NOT SET--',
                'label' => 'Collection Title',
            ))
            ->add('boxQuantity', 'collection', array(
                'type' => new MonthlyStatsArchivesBoxQuantityType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Boxes',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MonthlyStatsArchivesCollection'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_monthlystatsarchivescollection';
    }
}
