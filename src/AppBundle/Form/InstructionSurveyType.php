<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstructionSurveyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('studentFirstName')
            ->add('studentLastName')
            ->add('studentEmail')
            ->add('questionLearnedSomething')
            ->add('questionSkillsImproved')
            ->add('questionRelevantSession')
            ->add('questionKnowledgableSpeaker')
            ->add('questionClearlyExplained')
            ->add('questionIsFirstSession')
            ->add('questionDidUseEsearch')
            ->add('questionEsearchRelevant')
            ->add('questionMostImportantThingLearned')
            ->add('questionOtherQuestions')
            ->add('otherSuggestions')
            ->add('instruction')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\InstructionSurvey',
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_instructionsurvey';
    }
}
