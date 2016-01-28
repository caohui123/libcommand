<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EmailService{
  
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
   * Take a string and attach '@emich.edu' or take a string 
   * @param String $address  Either a properly-formatted Email address or string without '@emich.edu'
   */
  public function emichAddressFormatter($address){
    /*if(strpos($address, '@') === true){
      $arr_address = explode('@', $address);
      if($arr_address[1] != ''){
        throw new \BadMethodCallException('Nuuuuup!');
      }
    } else {
      return $address . '@emich.edu';
    }*/
    
            //throw new \RuntimeException('Nuuuuup!');

  }
  
}
