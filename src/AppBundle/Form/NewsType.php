<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('teaser', 'textarea', array(
              'label'=>'Teaser (100 character max)'
            ))
            ->add('body')
            ->add('hidden', null, array(
              'label' => 'Hide this news story from public view.'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_news';
    }
}
