<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\HoursSpecial;
use AppBundle\Entity\HoursRegular;

class HoursService{
  
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
  
  public function createSemesterDropdown(){
      //semesters dropdown
        $semesterForm = $this->container->get('form.factory')->createBuilder()
            ->add('semesters', 'entity', array(
                'class' => 'AppBundle:HoursSemester',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er){
                    return $er->createQueryBuilder('s')->orderBy('s.chronOrder', 'DESC');
                }, //order by year
                'label' => 'Semester',
                'property' => 'getSeasonYear' //string method to display choice
            ))
            ->getForm()
        ;
        
        return $semesterForm->createView();
  }
}
