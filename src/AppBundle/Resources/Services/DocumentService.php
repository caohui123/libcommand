<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use AppBundle\Entity\Document;

class DocumentService{
  
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
   * Routes a Document entity to its appropriate directory based on the 'category' value
   * 
   * @param AppBundle\Entity $entity
   * @return 
   */
  public function directoryRouter(Document $entity, $category){
        //route the document to its appropriate directory
        switch( $category ){
            case 'news':
                $entity->setSubDir('news');
                break;
            case 'profile':
                $entity->setSubDir('profile');
                break;
        };
        
        return;
  }
  
}