<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\DataTransformer\HoursAreaToIntTransformer;
use Doctrine\Common\Persistence\ObjectManager;

class HoursSpecialType extends AbstractType
{
    //need to instantiate HoursAreaToIntTransformer
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $area = $options['data']->getArea();
        if($area){
            $areaId = $area->getId();
        } else {
            $areaId = null;
        }

        $builder
            ->add('openTime', null, array(
                'label'=>'Open', 
                'widget'=>'single_text',
                'html5' => false  //input type="text" instead of "time"
            ))
            ->add('closeTime', null, array(
                'label'=>'Close', 
                'widget'=>'single_text',
                'html5' => false //input type="text" instead of "time"
            ))
            ->add('status', 'choice', array(
                'label'=>'Status',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    0 => 'Normal',
                    1 => '24 Hours',
                    2 => 'Closed'
                )
                ))
        ;
        
        
        
        /*
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SUBMIT, function(\Symfony\Component\Form\FormEvent $event){
            $em = $event->getForm()->getConfig()->getOption('em');
        });*/
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\HoursSpecial',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_hoursspecial';
    }
}

