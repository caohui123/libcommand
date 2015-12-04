<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Model\MutableAclProviderInterface as AclProvider; 

//USE USERREPOSITORY.PHP INSTEAD!!!
class UserService{
  
  protected $em;
  protected $container;
  protected $authorizationChecker;
  protected $aclProvider;
  
  public function __construct(EntityManager $em, ContainerInterface $container, AuthorizationCheckerInterface $authorizationChecker, AclProvider $aclProvider){
    $this->em = $em; //injected in services.yml [ @doctrine.orm.entity_manager ]
    $this->container = $container;
    $this->authorizationChecker = $authorizationChecker;
    $this->aclProvider = $aclProvider;
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
  }
  
  public function permissionsTable(){
    $permissionsTable = '
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Entity</th>
              <th>None</th>
              <th>View</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>AvRequest</td>
              <td><input type="radio"> None</td>
              <td><input type="radio"> View</td>
              <td><input type="radio"> Edit</td>
              <td><input type="radio"> Delete</td>
            </tr>
          </tbody>
        </table>
      ';
    return $permissionsTable;
  }

}

