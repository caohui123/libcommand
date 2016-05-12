<?php
namespace AppBundle\Resources\Services;

/**
 * This class is meant to provide helper functions for the uploading and downloading 
 * of documents (e.g. CSV files for instruction sessions).
 */

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;

class ImportExportService{
    
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
     * Creates a CallbackValueConverter to convert DateTime to a string for Ddeboer CSV generation
     * 
     * @return Ddeboer\DataImport\ValueConverter\CallbackValueConverter   The converter to be applied to DateTime fields.
     */
    public function convertDateTimeToString(){
        //Convert 
        $dateTimeToStringConverter = function($dateTime){
            return $dateTime->format('Y-m-d');
        };
                
        $converter = new CallbackValueConverter($dateTimeToStringConverter);
        
        return $converter;
    }
  
}

