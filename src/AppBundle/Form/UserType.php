<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\Bundle\DoctrineBundle\Registry;

class UserType extends AbstractType
{
  
    private $em;
    private $staffMember; //the ID of the staff member to use as the default selection in the dropdown
    private $roles; 
    /**
     * Inject entity manager for querying
     */
    public function __construct(Registry $em, $staffMember = null, $roles = null) {
      $this->em = $em;
      $this->staffMember = $staffMember;
      
      if(is_array($roles)){foreach($roles as $role => $val){
        $this->roles[] = $role;
      }};
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $this->_staffMemberData($this->staffMember);
        $builder
            ->add('isActive', 'checkbox', array('label'=> 'Active ', 'required'=>false, 'attr'=>array('class'=>'user-status-ckbx-noajax')))
            ->add('staffMember', 'entity', array(
              'class'=>'AppBundle:Staff',
              'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('s')->orderBy('s.lastName', 'ASC');
              },
              'data'=>$data,
              'label'=>'Associate this LDAP user with...',
              'attr'=>array('class' => 'form-control'),
              'placeholder' => 'No associated user',
              'choice_label' => 'getFirstLastName', //getFirstLastName() method in Staff class
              'required'=>false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
    
    /**
     * Determine default staff object to use when populating staff dropdown list.
     * @param int $staffMemberId
     * @return String $data Data to be passed to 'data' property of form builder
     */
    private function _staffMemberData($staffMemberId){
      if($staffMemberId == null){
        $data=null;
      } else {
        $staffMember = $this->em->getEntityManager()->createQuery(
              'SELECT s FROM AppBundle\Entity\Staff s WHERE s.id = :id'
            )->setParameter('id', $this->staffMember)->getSingleResult();
        $data = $this->em->getManager()->getReference('AppBundle:Staff', $staffMember->getId());
      }
      return $data;
    }
    
    /*public function getExistingRoles(){
      $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
      $roles = array_keys($roleHierarchy); 

      foreach ($roles as $role) {
          $theRoles[$role] = $role;
      }
      return $theRoles;
    }*/
}
