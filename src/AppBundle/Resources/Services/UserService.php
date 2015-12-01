<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

//USE USERREPOSITORY.PHP INSTEAD!!!
class UserService{
  
  protected $em;
  protected $container;
  
  public function __construct(EntityManager $em, ContainerInterface $container){
    $this->em = $em; //injected in services.yml [ @doctrine.orm.entity_manager ]
    $this->container = $container;
  }
  
  /**
   * @param String $type  null shows all users, active shows active, inactive shows inactive
   * @return Array $users   an array of user objects
   */
  
  public function listUsers($type = null){
    $repo = $this->em->getRepository('AppBundle\Entity\User');
    
    switch($type){
      case 'active':
        $users = $repo->findBy(array('isActive'=>1), array('username'=>'ASC'));
        break;
      case 'inactive':
        $users = $repo->findBy(array('isActive'=>0), array('username'=>'ASC'));
        break;
      default:
        $users = $repo->findAll();
    }

    return $users;
  }
  
  public function oneUser($id){
    return $this->container->getParameter('security.role_hierarchy.roles');
  }
}

