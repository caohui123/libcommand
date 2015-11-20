<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;


//USE USERREPOSITORY.PHP INSTEAD!!!
class UserService{
  /*
  protected $em;
  
  public function __construct(EntityManager $em){
    $this->em = $em;
  }
  
  /**
   * @param String $type  null shows all users, active shows active, inactive shows inactive
   * @return Array $users   an array of user objects
   */
  /*
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
  }*/
}

