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
    private $specialHour;

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
        
        //add in these fields only if the HoursSpecial object is new using an event listener
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function(\Symfony\Component\Form\FormEvent $event){
            $specialHour = $event->getData();
            $form = $event->getForm();
            
            // check if the HoursSpecial object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "HoursSpecial"
            if(!$specialHour || null === $specialHour->getId()){
                $form->add('eventDate', new \AppBundle\Form\Type\HiddenDateTimeType());
                $form->add('area', new \AppBundle\Form\Type\HiddenHoursAreaType($this->manager));
                $form->add('event', 'entity', array(
                    'class'=>'AppBundle:HoursEvent',
                ));
            }
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\HoursSpecial',
            'csrf_protection' => false,
            'evDate' => null
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

