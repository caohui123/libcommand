<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MonthlyStatsArchivesBookQuantityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bookTitle', 'entity', array(
                'label' => 'Title',
                'class'=>'AppBundle:MonthlyStatsArchivesBookTitle',
                'query_builder'=>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('b');
                    $qb
                      ->orderBy('b.name', 'ASC')
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
            'data_class' => 'AppBundle\Entity\MonthlyStatsArchivesBookQuantity'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_monthlystatsarchivesbookquantity';
    }
}
