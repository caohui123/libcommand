<?php
namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\Staff;

class InstructionService{
  
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
     * Return a formatted list of filters applied to an instruction search
     * 
     * @param array $rawFilters  The unformatted list of filters
     * @return array $filters    The formatted list of filters
     */
    public function formatFilters($rawFilters){
        $filters = array();
        
        //LIBRARIAN NAME
        if(array_key_exists('librarian', $rawFilters)){         
            if($rawFilters['librarian'] != ''){
                $filters['librarian'] = $this->__getStaffById($rawFilters['librarian']);
            }
        } 
        
        //PROGRAM NAME
        if(array_key_exists('program', $rawFilters)){       
            if($rawFilters['program'] != ''){
                $filters['program'] = $this->__getProgramById($rawFilters['program']);
            }
        } 
        
        //INSTRUCTION TYPE
        if(array_key_exists('instructionType', $rawFilters)){  
            $instructionType = $this->formatInstructionType($rawFilters['instructionType']);
            $filters['instructionType'] = $instructionType;
        } 
        
        //FILTER CRITERIA (academic, fiscal, calendar, semester, custom)
        if(array_key_exists('filterCriteria', $rawFilters)){  
            $instructionType = $this->formatInstructionType($rawFilters['instructionType']);
            $filters['instructionType'] = $instructionType;
            
            switch($rawFilters['filterCriteria']){
                case 'academic':
                    array_key_exists('academicYear', $rawFilters) ? $year = $rawFilters['academicYear'] . '-' . ($rawFilters['academicYear'] + 1) : $year = '';
                    $criteriaYear = "Academic Year " . $year;
                    break;
                case 'calendar':
                    array_key_exists('calendarYear', $rawFilters) ? $year = $rawFilters['calendarYear'] : $year = '';
                    $criteriaYear = "Calendar Year " . $year;
                    break;
                case 'fiscal':
                    array_key_exists('fiscalYear', $rawFilters) ? $year = $rawFilters['fiscalYear'] . '-' . ($rawFilters['fiscalYear'] + 1) : $year = '';
                    $criteriaYear = "Fiscal Year " . $year;
                    break;
                case 'semester':
                    array_key_exists('year', $rawFilters) ? $year = $rawFilters['year'] : $year = '';
                    $criteriaYear = ucfirst($rawFilters['semester']) . ' ' . $year;
                    break;
                case 'custom':
                    array_key_exists('startDate', $rawFilters) ? $startDate = $rawFilters['startDate'] : $startDate = '';
                    array_key_exists('endDate', $rawFilters) ? $endDate = $rawFilters['endDate'] : $endDate = '';
                    $criteriaYear = 'Date Range: ' . $startDate . ' to ' . $endDate;
                    break;
            }
            
            $filters['year'] = $criteriaYear;
        } 
        
        //LEVEL 
        if(array_key_exists('level', $rawFilters)){              
            $filters['level'] = ucfirst($rawFilters['level']);
        } 
        
        //LAST n MONTHS
        if(array_key_exists('lastmonths', $rawFilters)){              
            $filters['lastmonths'] = 'Last '.$rawFilters['lastmonths'].' months';
        } 
        
        return $filters;
    }
    
    /**
     * Format the instruction type for display.
     * 
     * @param string $raw
     * @return string
     */
    public function formatInstructionType($raw){
        switch($raw){
            case 'group':
                $instructionType = 'Group Sessions Only';
                break;
            case 'individual':
                $instructionType = 'Individual Sessions Only';
                break;
            default:
                $instructionType = 'Group and Individual Sessions';
                break;
        }
        
        return $instructionType;
    }
    
    /**
     * Return a list of Instruction entites based on the criteria from the search form.
     * 
     * @var array $criteria  Form data with criteria.
     * @return array
     */
    public function getInstructionsByCriteria($criteria){
        $options = array();

        $query = "SELECT i FROM ";
        
        // ALL/GROUP/INDIVIDUAL INSTRUCTION FILTER
        if(isset($criteria['instructionType'])){
            switch($criteria['instructionType']){
                case 'group':
                    $query .= "AppBundle:GroupInstruction i ";
                    break;
                case 'individual':
                    $query .= "AppBundle:IndividualInstruction i ";
                    break;
                default:
                    $query .= "AppBundle:Instruction i ";
                    break;
            }
        } else {
            $query .= "AppBundle:Instruction i ";
        }
        
        $query .= "WHERE i.id IS NOT NULL ";
        
        //LIBRARIAN
        if(isset($criteria['librarian'])){
            if($criteria['librarian'] instanceof \AppBundle\Entity\Staff && $criteria['librarian'] != null){
                $options['librarian'] = $criteria['librarian'];
                $query .= "AND i.librarian = :librarian ";
            }
        }
        
        //PROGRAM
        if(isset($criteria['program'])){
            if($criteria['program'] instanceof \AppBundle\Entity\LiaisonSubject && $criteria['program'] != null){
                $options['program'] = $criteria['program'];
                $query .= "AND i.program = :program ";
            }
        }
        
        //LEVEL
        if(isset($criteria['level'])){
            if($criteria['level'] != ''){
                $options['level'] = $criteria['level'];
                $query .= "AND i.level = :level ";
            }
        }
        
        //FISCAL YEAR
        if(isset($criteria['fiscalYear'])){
            if($criteria['fiscalYear'] != ''){
                $options['firstYear'] = new \DateTime($criteria['fiscalYear'] . '-07-01');
                $options['secondYear'] = new \DateTime($criteria['fiscalYear'] + 1 . '-06-30');
                $query .= "AND i.instructionDate >= :firstYear AND i.instructionDate <= :secondYear ";
            }
        }
        
        //ACADEMIC YEAR
        if(isset($criteria['academicYear'])){
            if($criteria['academicYear'] != ''){
                $options['firstYear'] = new \DateTime($criteria['academicYear'] . '-09-01');
                $options['secondYear'] = new \DateTime($criteria['academicYear'] + 1 . '-08-31');
                $query .= "AND i.instructionDate >= :firstYear AND i.instructionDate <= :secondYear ";
            }
        }
        
        //ACADEMIC YEAR
        if(isset($criteria['calendarYear'])){
            if($criteria['calendarYear'] != ''){
                $options['startOfYear'] = new \DateTime($criteria['calendarYear'] . '-01-01');
                $options['endOfYear'] = new \DateTime($criteria['calendarYear'] . '-12-31');
                $query .= "AND i.instructionDate >= :startOfYear AND i.instructionDate <= :endOfYear ";
            }
        }
        
        //ACADEMIC YEAR
        if(isset($criteria['semester'])){
            if($criteria['semester'] != ''){
                switch($criteria['semester']){
                    case 'winter':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-01-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-04-30');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                    case 'spring':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-05-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-06-30');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                    case 'summer':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-07-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-08-31');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                    case 'fall':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-09-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-12-31');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                }
            }
        }
        
        //CUSTOM START AND END DATE
        if( isset($criteria['startDate']) && isset($criteria['endDate']) ){
            if( ($criteria['startDate'] instanceof \DateTime && $criteria['startDate'] != null) && ($criteria['endDate'] instanceof \DateTime && $criteria['endDate'] != null) ){
                //start and end date set
                $options['instructionStartDate'] = $criteria['startDate'];
                $options['instructionEndDate'] = $criteria['endDate'];
                $query .= "AND i.instructionDate >= :instructionStartDate AND i.instructionDate <= :instructionEndDate ";
            } else if ( ($criteria['startDate'] instanceof \DateTime && $criteria['startDate'] != null) && ( !($criteria['endDate'] instanceof \DateTime) || $criteria['endDate'] == null) ){
                // start date set but NOT end date
                $options['instructionStartDate'] = $criteria['startDate'];
                $query .= "AND i.instructionDate >= :instructionStartDate ";
            } else if ( ( !($criteria['startDate'] instanceof \DateTime) || $criteria['startDate'] == null) && ( $criteria['endDate'] instanceof \DateTime && $criteria['endDate'] != null) ) {
                // end date set but NOT start date
                $options['instructionEndDate'] = $criteria['endDate'];
                $query .= "AND i.instructionDate <= :instructionEndDate ";
            }
        }
        
        //LAST n MONTHS
        if( isset($criteria['lastmonths']) ){
            $monthRange = (int) $criteria['lastmonths']; //beginning now, search instructions for the last n months
            
            $endDate = new \DateTime();
            $startDate = new \DateTime();
            $startDate->sub(new \DateInterval('P'.$monthRange.'M'));
                    
            $options['instructionStartDate'] = $startDate;
            $options['instructionEndDate'] = $endDate;
            $query .= "AND i.instructionDate >= :instructionStartDate AND i.instructionDate <= :instructionEndDate ";
        }

        $query .= " ORDER BY i.instructionDate DESC";
        $qb = $this->em->createQuery($query)->setParameters($options);
        
        return $qb->getResult();
    }
    
    /**
     * Based on the staff member, generate a count of the instructions over a certain period of time.
     * 
     * @param Staff $staff
     * @return array
     */
    public function generateStaffRecentInstructionStatistics(Staff $staff = null){
        $now = new \DateTime();
        $last3Months = clone $now;
        $last3Months->sub(new \DateInterval('P3M'));
        $last6Months = clone $now;
        $last6Months->sub(new \DateInterval('P6M'));
        $last9Months = clone $now;
        $last9Months->sub(new \DateInterval('P9M'));
        $last12Months = clone $now;
        $last12Months->sub(new \DateInterval('P12M'));
        
        $countStats3Months = $this->__getStaffInstructionCountByTimeFrame($staff, $last3Months, $now);
        $countStats6Months = $this->__getStaffInstructionCountByTimeFrame($staff, $last6Months, $now);
        $countStats9Months = $this->__getStaffInstructionCountByTimeFrame($staff, $last9Months, $now);
        $countStats12Months = $this->__getStaffInstructionCountByTimeFrame($staff, $last12Months, $now);
        $countStatsAllMonths = $this->__getStaffInstructionCountByTimeFrame($staff);
        
        return array(
            'last3Months' => $countStats3Months,  
            'last6Months' => $countStats6Months,
            'last9Months' => $countStats9Months,
            'last12Months' => $countStats12Months,
            'allMonths' => $countStatsAllMonths,
        );
    }
    
    /**
     * Get the most recent instruction session for a staff member (provided that instruction session is not in the future).
     * @param Staff $staff
     * @return AppBundle:Entity:Instruction 
     */
    public function getMostRecentInsturction(Staff $staff){
        $options = array();
        $options['staff'] = $staff;
        $options['now'] = new \DateTime();
        
        // Uses Symfony's QUERY BUILDER (as opposed to standard DQL queries used in other functions in this service)
        $repo = $this->em->getRepository('AppBundle\Entity\Instruction');
        $query = $repo->createQueryBuilder('i')
                    ->where('i.instructionDate <= :now AND i.librarian = :staff')
                    ->orderBy('i.instructionDate', 'DESC')
                    ->setParameter('now', new \DateTime())
                    ->setParameter('staff', $staff)
                    ->setMaxResults(1)
                    ->getQuery();
        
        return $query->getOneOrNullResult();
    }
    
    /**
     * Get group instructions count by month for a specific staff member or all staff members
     * 
     * @param DateTime $month
     * @param Staff $staff
     */
    public function getGroupInstructionsByMonth(\DateTime $month, $level = null, Staff $staff = null){
        $nextMonth = clone $month;
        $nextMonth->add(new \DateInterval('P1M'));

        // Uses Symfony's QUERY BUILDER
        $repo = $this->em->getRepository('AppBundle\Entity\GroupInstruction');
        $query = $repo->createQueryBuilder('i')
                    ->select('count(i.id)')
                    ->where('i.instructionDate >= :startDate AND i.instructionDate < :endDate')
                    ->orderBy('i.instructionDate', 'DESC')
                    ->setParameter('startDate', $month)
                    ->setParameter('endDate', $nextMonth)
                        ;
        if($level != null){          
            $query
                ->andWhere('i.level = :level')
                ->setParameter('level', $level);
        }
        
        if($staff != null){          
            $query
                ->andWhere('i.librarian = :librarian')
                ->setParameter('librarian', $staff);
        }
        
        return $query->getQuery()->getSingleScalarResult();
    }
    
    /**
     * Get group instruction total attendance by month for a specific staff member or all staff members
     * 
     * @param DateTime $month
     * @param Staff $staff
     */
    public function getGroupInstructionAttendanceByMonth(\DateTime $month, $level = null, Staff $staff = null){
        $nextMonth = clone $month;
        $nextMonth->add(new \DateInterval('P1M'));

        // Uses Symfony's QUERY BUILDER
        $repo = $this->em->getRepository('AppBundle\Entity\GroupInstruction');
        $query = $repo->createQueryBuilder('i')
                    ->select('sum(i.attendance)')
                    ->where('i.instructionDate >= :startDate AND i.instructionDate < :endDate')
                    ->setParameter('startDate', $month)
                    ->setParameter('endDate', $nextMonth)
                    ;
        
        if($level != null){          
            $query
                ->andWhere('i.level = :level')
                ->setParameter('level', $level);
        }
        
        if($staff != null){          
            $query
                ->andWhere('i.librarian = :librarian')
                ->setParameter('librarian', $staff);
        }
        
        $result = $query->getQuery()->getSingleScalarResult();
        
        $result ? $return = $result : $return = 0;
        
        return $return;
    }
    
    /**
     * Get group instruction totals for 12-month period for a specific staff member or all staff members
     * 
     * @param DateTime $startMonth The first month for which to gather instruction totals
     * @param Staff $staff
     */
    public function getStaffGroupInstructionTotalsByYear($yearType, $year, Staff $staff = null){
        
        switch($yearType){
            case 'academic':
                $startDate = new \DateTime($year . "-09-01");
                $endDate = new \DateTime(($year + 1) . "-08-31");
                break;
            case 'fiscal':
                $startDate = new \DateTime($year . "-07-01");
                $endDate = new \DateTime(($year + 1) . "-06-30");
                break;
        }

        // Uses Symfony's QUERY BUILDER
        $repo = $this->em->getRepository('AppBundle\Entity\GroupInstruction');
        $query = $repo->createQueryBuilder('i')
                    ->select('count(i.id)')
                    ->where('i.instructionDate >= :startDate AND i.instructionDate < :endDate')
                    ->setParameter('startDate', $startDate)
                    ->setParameter('endDate', $endDate)
                    ;
        
        if($staff != null){          
            $query
                ->andWhere('i.librarian = :librarian')
                ->setParameter('librarian', $staff);
        }
        
        $result = $query->getQuery()->getSingleScalarResult();
        
        $result ? $return = $result : $return = 0;
        
        return $return;
    }
    

    /**
     * Generate a list of years for criteria choices
     * @param bool $range  True = "2015-2016" format; False = "2016" format
     * @param int $startYear
     * @param int $endYear
     * @return array $range 
     */
    public function generateYears($range = true, $startYear = 2015, $endYear = null){
        $years_arr = array();
        
        $currentYear = date('Y'); //string
        $currentMonth = date('m');
        
        if($endYear != null){
            for($i = $endYear; $i >= $startYear; $i--){
                $range ? $years_arr[$i] = $i . '-' . ($i + 1) : $years_arr[$i] = $i;
            }
        } else {
            //show next year if it's May or later
            if($currentMonth >= 5){
                for($i = $currentYear; $i >= $startYear; $i--){
                    $range ? $years_arr[$i] = $i . '-' . ($i + 1) : $years_arr[$i] = $i;
                }
            } else {
                for($i = $currentYear - 1; $i >= $startYear; $i--){
                    $range ? $years_arr[$i] = $i . '-' . ($i + 1) : $years_arr[$i] = $i;
                }
            }
        }
        
        return $years_arr;
    }
    
    /**
     * Get a staff member by id (used in formatFilters())
     * 
     * @param type $id
     * @return string
     * @throws CreateNotFoundException
     */
    private function __getStaffById($id){
       
        $entity = $this->em->getRepository('AppBundle\Entity\Staff')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
        }
        
        $staff = $entity->getFirstName() . ' ' . $entity->getLastName();
        
        return $staff;
    }
    
    /**
     * Get a program (LiaisonSubject) by id (used in formatFilters())
     * 
     * @param int $id
     * @return string
     * @throws CreateNotFoundException
     */
    private function __getProgramById($id){

        $entity = $this->em->getRepository('AppBundle\Entity\LiaisonSubject')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LiaisonSubject entity.');
        }
        
        $program = $entity->getName();
        
        return $program;
    }
    
    /**
     * Get a count of staff instructions for a given time frame. Pass null to $staff to get all instructions for a time frame.
     * 
     * @param int $id
     * @param DateTime $startDate
     * @param DateTime $endDate
     */
    private function __getStaffInstructionCountByTimeFrame(Staff $staff = null, \DateTime $startDate = null, \DateTime $endDate = null){        
        $options = array();
        
        $query = "SELECT COUNT(i.id) FROM AppBundle\Entity\Instruction i WHERE i.id IS NOT NULL ";
        
        if($staff != null){
            $options['staff'] = $staff;
            $query .= "AND i.librarian = :staff ";
        }
        
        if($startDate != null && $endDate != null){
            $options['startDate'] = $startDate;
            $options['endDate'] = $endDate;
            $query .= "AND i.instructionDate >= :startDate AND i.instructionDate <= :endDate ";
        } else if ($startDate != null && $endDate == null) {
            $options['startDate'] = $startDate;
            $query .= "AND i.instructionDate >= :startDate ";
        } else if ($startDate == null && $endDate != null) {
            $options['endDate'] = $endDate;
            $query .= "AND i.instructionDate <= :endDate ";
        }
        
        $query .= "ORDER BY i.instructionDate DESC";
        
        $qb = $this->em->createQuery($query)->setParameters($options);
        
        return $qb->getSingleScalarResult();
    }
}
