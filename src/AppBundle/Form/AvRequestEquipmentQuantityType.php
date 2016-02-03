<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AvRequestEquipmentQuantityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipment', 'entity', array(
              'class' => 'AppBundle:AvRequestEquipment',
              'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('eq');
                  $qb
                    ->orderBy('eq.name', 'ASC')
                    ->getQuery();
                  return $qb;
              },
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
            'data_class' => 'AppBundle\Entity\AvRequestEquipmentQuantity'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_avrequestequipmentquantity';
    }
}
