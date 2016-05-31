<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Role\RoleHierarchy;
use FOS\UserBundle\Util\UserManipulator;

class UserService{
  
  protected $em;
  protected $container;
  protected $authorizationChecker;
  protected $manipulator;
  
  public function __construct(EntityManager $em, ContainerInterface $container, AuthorizationCheckerInterface $authorizationChecker, UserManipulator $manipulator){
    $this->em = $em; //injected in services.yml [ @doctrine.orm.entity_manager ]
    $this->container = $container;
    $this->authorizationChecker = $authorizationChecker;
    $this->manipulator = $manipulator;
  }
  
  /**
   * Updates a user's role on a specific entity.
   * Usually called from UserController::updatePermissionsAction()
   * 
   * @param User $user The user being updated
   * @param String $newPermission The name of the new role
   * @param String $previousPermission The name of the previous role
   * 
   * @return null
   */
  public function updatePermissions(User $user, $newPermission, $previousPermission){
      //utilize the FOS\UserBundle\Util\UserManipulator;
      $fos = $this->manipulator;

      //remove the old role
      $fos->removeRole($user, $previousPermission);
      if($newPermission != 'none' && $newPermission != '' && $newPermission != null){
        //add the new role
        $fos->addRole($user, $newPermission);
      }
  }
  
  /**
   * Concatenates a role prefix (e.g. ROLE_AV) with the appropriate suffix (e.g. _DELETE)
   * 
   * @param User $user The user entity
   * @param String $prefix The role prefix
   * 
   * @return String $permission The concatenated permission name.
   */
  public function generateViewEditDelete(User $user, $prefix){
    $userPermissions = $user->getRoles();
    
    if(in_array($prefix.'_DELETE', $userPermissions)){
      $permission = $prefix.'_DELETE';
    } else if(in_array($prefix.'_EDIT', $userPermissions)) {
      $permission = $prefix.'_EDIT';
    } else if(in_array($prefix.'_VIEW', $userPermissions)){
      $permission = $prefix.'_VIEW';
    } else {
      $permission = 'none';
    }
    
    return $permission;
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
  
/**
 * ACLs grant user permission on every instance of each entity.
 * In order to edit permissions across all of these entites for each user,
 * first iterate over all entities. 
 * For each entity, update the permission for the specified user.
 *
 * @param  \AppBundle\Entity\User $user  The user object whose permissions should be updated
 * @param String $entity  The entity whose permissions should be updated (e.g. 'AppBundle:AvRequest')
 * @param int $permission  The bitmask value of the permission level (e.g. MaskBuilder::MASK_VIEW (=4))
 * 
 * @return null
 */

/*
  public function editPermission(User $user, $entity, $permission){
    $allEntities = $this->em->getRepository($entity)->findAll();
    
    foreach($allEntities as $oneEntity){
      // locate the ACL
      $objectIdentity = ObjectIdentity::fromDomainObject($oneEntity);
      $acl = $this->aclProvider->findAcl($objectIdentity);
      
      // update user access
      $objectAces = $acl->getObjectAces();
      foreach($objectAces as $i => $ace) {
          $acl->updateObjectAce($i, $permission); 
      }
    }
  }*/

}

