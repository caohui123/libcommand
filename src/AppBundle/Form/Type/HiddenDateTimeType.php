<?php

/* 
 * A custom type that allows a hidden field for HoursArea entities
 */
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\DataTransformer\DateTimeToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;

class HiddenDateTimeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new DateTimeToStringTransformer();
        $builder->addModelTransformer($transformer);
    }
    
    
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }
        
    /**
     * 
     * the return value of the getParent function indicates that you're extending the choice field type. 
     * This means that, by default, you inherit all of the logic and rendering of that field type.
     */
    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'app_hoursEvent';
    }
}

