<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Staff;

class InstructionSearchType extends AbstractType
{    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder    
            ->add('librarian', 'entity', array(
                'class' => 'AppBundle:Staff',
                'query_builder' => function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('st');
                    $qb
                        ->where('st.employmentStatus = :employmentStatus')
                        ->setParameter('employmentStatus', 'faclib')
                        ->orderBy('st.lastName', 'DESC')
                        ->getQuery();
                    return $qb;
                },
                'placeholder' => 'All Librarians',
                'required' => false
            ))
            ->add('program', 'entity', array(
                'class' => 'AppBundle:LiaisonSubject',
                'query_builder'=>function(EntityRepository $er){
                  $qb = $er->createQueryBuilder('ls');
                  $qb
                    ->orderBy('ls.root, ls.lvl, ls.name', 'ASC')
                    ->getQuery();
                  return $qb;
                },
                'property' => 'indentedTitle',
                'placeholder' => 'All Programs',
                'required' => false,
                'label' => 'Program'
            ))
            ->add('startDate', 'date', array(
                'html5' => false,
                'widget' => 'single_text',
                'label' => 'From'
            ))
            ->add('endDate', 'date', array(
                'html5' => false,
                'widget' => 'single_text',
                'label' => 'To',
                'required' => false,
            ))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'instrsearch';
    }
}
