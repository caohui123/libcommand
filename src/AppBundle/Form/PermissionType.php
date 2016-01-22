<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;

class PermissionType extends AbstractType
{
    private $roles;

    public function __construct(ContainerInterface $container) {
      $this->roles = $container->getParameter('security.role_hierarchy.roles');
    }
    
    public function getDefaultOptions(array $options){
      return array('choices' => $this->roles);
    }

    public function getName()
    {
        return 'permission_choice';
    }
}
