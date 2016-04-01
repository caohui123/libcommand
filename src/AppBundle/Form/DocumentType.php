<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Image;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Image Name'
            ))
            ->add('file', null, array(
                'label' => 'Image (.jpg only)',
                'constraints' => array(
                    new Image(['mimeTypes' => 'image/jpeg', 'mimeTypesMessage' => 'Only .JPG images allowed.'])
                )
            ))
            //->add('category') SET THIS FIELD MANUALLY EACH TIME!!
        ;
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_document';
    }
}
