<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\Staff;

class StaffService{
  
  protected $em;
  protected $container;
  protected $authorizationChecker;
  protected $router;
  
  public function __construct(EntityManager $em, ContainerInterface $container, AuthorizationCheckerInterface $authorizationChecker, Router $router)
  {
        $this->em = $em; //injected in services.yml [ @doctrine.orm.entity_manager ]
        $this->container = $container;
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
  }
  
    /**
     * Find Staff entity/entities by name based on a given string.
     * Place each id, first and last name in an array.
     * Used, for example, in staff search boxes.
     * 
     * @return array Staff entities.
     */
    public function getAllStaffForAutocomplete(){
        // Uses Symfony's QUERY BUILDER
        $repo = $this->em->getRepository('AppBundle\Entity\Staff');
        $query = $repo->createQueryBuilder('s')
                    ->orderBy('s.lastName', 'ASC')
                        ;
        
        $entities = $query->getQuery()->getResult();
        
        $staff_arr = array();
        foreach($entities as $entity){
            $staff_arr[] = array('id' => $entity->getId(), 'value' => $entity->getLastName() . ', ' . $entity->getFirstName());
        }
        
        return $staff_arr;
    }
}