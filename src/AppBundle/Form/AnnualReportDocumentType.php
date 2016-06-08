<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\File;

class AnnualReportDocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Title'
            ))
            ->add('file', null, array(
                'label' => 'Document',
                'constraints' => array(
                    new File(['mimeTypes' => array('text/plain', 'application/plain', 'application/pdf', 'text/csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 	
'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'), 'mimeTypesMessage' => 'Only .PDF, .DOC(X), .XLS(X), .PPT(X), .CSV, .TXT file types allowed.'])
                )
            ))
            ->add('category', 'choice', array(
                'label' => 'Category',
                'choices' => array(
                    'service' => 'Service Transactions',
                    'processing' => 'Processing Statistics',
                    'other' => 'Other',
                ),
            ))
            ->add('subdir', 'hidden', array(
                'data' => 'annualreport'
            ))
        ;
        
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AnnualReportDocument'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_annualreport';
    }
}
