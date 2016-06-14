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

class MonthlyStatisticsService{
    
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
     * Generate a yearly report (fiscal or academic) for government documents
     * 
     * @param mixed $year
     * @param String $period
     * @param array $options either an empty array or an array with values "holdings, usage, processing" or a mixture of those 
     * @return array $report  An array returning the results.
     */
    public function generateGovdocsYearlyReport($year, $period = 'fiscal'){
        if($period  == 'fiscal'){
            $year = $this->__trimYear($year);
            
            $startDate = new \DateTime($year.'-07-01');
            $endDate = new \DateTime(($year+1).'-06-30');
        }
        
        if($period == 'calendar'){
            $startDate = new \DateTime($year.'-01-01');
            $endDate = new \DateTime($year.'-12-31');
        }
        
        $monthRecord = array();
        for($i = 0; $i < 12; $i++){
            $nextMonth = clone $startDate;
            $nextMonth->add(new \DateInterval('P'.$i.'M'));
            
            $monthRecord[] = $this->__getMonthRecord('govdocs', $nextMonth);
        }

        return $monthRecord;
    }
    
    public function monthlyTablesByYear($statsType, $startYear = 2015){
        switch($statsType){
            case 'govdocs':
                $path = 'monthly_govdocs';
                break;
            case 'map':
                break;
            case 'periodical':
                break;
            case 'archives':
                break;
        }
        
        $tables = '';
        for($thisyear = date('Y'); $thisyear >= $startYear; $thisyear--){
            $tables .= '
                <table class="table table-condensed">
                    <caption>Year '.$thisyear.'</caption>
                    <thead>
                        <tr>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Aug</th>
                            <th>Sep</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <tr>
            ';
            for($i = 1; $i <= 12; $i++){
                $tables .= '<td>';
                
                $monthRecord = $this->__getMonthRecord( $statsType, new \DateTime($thisyear.'-'.$i.'-01') );
                
                // If the query turns up a record for the month, show a "pencil" glyph with a link to the edit page
                if($monthRecord){
                    $tables .= '<a href="'.$this->router->generate( $path.'_edit', array( 'id' => $monthRecord->getId() )).'"><span class="glyphicon glyphicon-pencil"></span></a>';
                } else {
                    // No record for the month? Show an "add" glyph with a link to the new page for the given month
                    $tables .= '<a href="'.$this->router->generate( $path.'_new', array( 'month' => date($thisyear.'-'.$i.'-01') )).'"><span class="glyphicon glyphicon-plus"></span></a>';
                }
                
                $tables .= '</td>';
            }
            
            $tables .= '
                        </tr>
                    </tbody>
                </table>
            ';
        }
        
        return $tables;
    }
    
    private function __getMonthRecord($statsType, \DateTime $month){
        
        switch($statsType){
            case 'govdocs':
                // Uses Symfony's QUERY BUILDER (as opposed to standard DQL queries)
                $repo = $this->em->getRepository('AppBundle\Entity\MonthlyStatsGovernmentDocuments');
                break;
            case 'map':
                break;
            case 'periodical':
                break;
            case 'archives':
                break;
        }
        
        $query = $repo->createQueryBuilder('ms')
                    ->where('ms.month = :month')
                    ->setParameter('month', $month)
                    ->setMaxResults(1)
                    ->getQuery();
        
        return $query->getOneOrNullResult();
    }
    
    private function __trimYear($year){
        $years = explode('-', $year);
        
        return $years[0];
    }
}

