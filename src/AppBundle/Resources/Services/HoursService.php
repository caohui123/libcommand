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
            ->setAction($this->router->generate('semester_reghours'))  
            ->setMethod('GET')
            ->getForm()
        ;
        
        return $semesterForm->createView();
  }
  
  /**
   * Return a 7-day date range for the given date
   * 
   * @param DateTime $date  The date for which the date range should be found
   * @param int $weekStart  The numeric day of the week (1=Monday thru 7=Sunday)
   * 
   * @return array The range of dates for the week
   */
  public function getWeekDateRange(\DateTime $date, $weekStart = 7){
      $firstDayOfWeek = $weekStart;
      
      $difference = ($firstDayOfWeek - $date->format('N'));
      if($difference > 0){ 
          $difference -= 7; 
      }
      $startDateRaw = $date->modify("$difference days");
      
      return array(
          0 => $startDateRaw->format('Y-m-d'),
          1 => $startDateRaw->modify('+1 day')->format('Y-m-d'),
          2 => $startDateRaw->modify('+1 day')->format('Y-m-d'),
          3 => $startDateRaw->modify('+1 day')->format('Y-m-d'),
          4 => $startDateRaw->modify('+1 day')->format('Y-m-d'),
          5 => $startDateRaw->modify('+1 day')->format('Y-m-d'),
          6 => $startDateRaw->modify('+1 day')->format('Y-m-d'),
      );
  }
}
