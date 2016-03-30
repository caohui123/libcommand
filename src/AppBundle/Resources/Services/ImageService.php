<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Finder\Finder;

class ImageService{
  
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
   * Use the Symfony Finder component to find all images in a directory
   * 
   * @param string $directoryPath
   * @return Finder
   */
  public function findDirectoryImages($directoryPath){
        $finder = new Finder();
        $images = $finder->files()->in($directoryPath);
        
        return $images;
  }
  
}