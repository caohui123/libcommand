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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
    
    /**
     * Create a series of Add/Edit tables on the Monthly Stats entity's index.html.twig page 
     * 
     * @param String $statsType  Either 'govdocs', 'map', 'periodical', or 'archives'
     * @param int $startYear  From what year should the tables be printed?
     * @return string $tables  The HTML table for the year.
     */
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
    
    /**
     * Create a CSV file for the given govdocs data for either a fiscal or academic year.
     * 
     * @param String $reportType  Either 'fiscal' or 'academic'
     * @param String $reportYear 
     * @param type $reportOptions
     * @param array $data  Contains an array (ordered by month) of MonthlyStatsGovernmentDocuments entities where applicable records are found; 
     *                     where applicable records are not found, null is present in that slot.   
     * @return StreamedResponse $response  A ready-to-go Symfony response which will generate the file when returned by a calling controller method.
     */
    public function assembleGovDocsCSV($reportType, $reportYear, $reportOptions, $data){
        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();
        
        $phpExcelObject->getProperties()
                ->setCreator($this->container->get('security.context')->getToken()->getUser()->getUsername())
                ->setTitle('Government Documents Statistics: ' . ucfirst($reportType) . ' Year ' . $reportYear)
                ;
        
        // Start writing the Excel file.
        $num_sheets = 0;
             
        // Generate holdings stats.
        if(in_array('holdings', $reportOptions)){
            //Holdings totals variables
            $totalItemsAdded = 0;
            $totalItemsWithdrawn = 0;
            $totalItems = 0;
            
            //Excel file
            $phpExcelObject->setActiveSheetIndex($num_sheets);
            
            $this->__getGovDocsCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A2', "Items Added (gross)")
                    ->setCellValue('A3', "Items Withdrawn")
                    ->setCellValue('A4', "Net Items")
                    ;
            
            //Populate the data for each category for each month of the year
            $cell_counter = range('B','Z');
            $month_counter = 0;
            while($month_counter < 12){
                // Sometimes no record will exsit for a given month. If that's the case, set all values for that month to 0.
                if($data[$month_counter] == null){
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'2', 0)
                        ->setCellValue($cell_counter[$month_counter].'3', 0)
                        ->setCellValue($cell_counter[$month_counter].'4', 0)
                        ;
                } else {
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'2', $data[$month_counter]->getItemsAddedGross())
                        ->setCellValue($cell_counter[$month_counter].'3', $data[$month_counter]->getItemsWithdrawn())
                        ->setCellValue($cell_counter[$month_counter].'4', ($data[$month_counter]->getItemsAddedGross() - $data[$month_counter]->getItemsWithdrawn()))
                        ;
                    
                    $totalItemsAdded += $data[$month_counter]->getItemsAddedGross();
                    $totalItemsWithdrawn += $data[$month_counter]->getItemsWithdrawn();
                    $totalItems += ($totalItemsAdded - $totalItemsWithdrawn);
                }
                $month_counter++;
            }
            
            //Totals
            $phpExcelObject->getActiveSheet()
                ->setCellValue($cell_counter[$month_counter].'2', $totalItemsAdded)
                ->setCellValue($cell_counter[$month_counter].'3', $totalItemsWithdrawn)
                ->setCellValue($cell_counter[$month_counter].'4', ($totalItemsAdded - $totalItemsWithdrawn))
                ;
            $month_counter++;
            
            $phpExcelObject->getActiveSheet()->setTitle("Holdings");
            $num_sheets++; //increment our num_sheets counter
        }
        
        // Generate usage stats.
        if(in_array('usage', $reportOptions)){
            //Holdings totals variables
            $totalPaper = 0;
            $totalElectronicOPACURLs = 0;
            
            $phpExcelObject->createSheet($num_sheets); //create a new sheet.
            $phpExcelObject->setActiveSheetIndex($num_sheets);
            
            $this->__getGovDocsCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A2', "Papers")
                    ->setCellValue('A3', "Electronic OPAC URLs")
                    ;
            
            //Populate the data for each category for each month of the year
            $cell_counter = range('B','Z');
            $month_counter = 0;
            while($month_counter < 12){
                // Sometimes no record will exsit for a given month. If that's the case, set all values for that month to 0.
                if($data[$month_counter] == null){
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'2', 0)
                        ->setCellValue($cell_counter[$month_counter].'3', 0)
                        ;
                } else {
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'2', $data[$month_counter]->getPaper())
                        ->setCellValue($cell_counter[$month_counter].'3', $data[$month_counter]->getElectronicOpacUrls())
                        ;
                    
                    $totalPaper += $data[$month_counter]->getPaper();
                    $totalElectronicOPACURLs += $data[$month_counter]->getElectronicOpacUrls();
                }
                $month_counter++;
            }
            
            //Totals
            $phpExcelObject->getActiveSheet()
                ->setCellValue($cell_counter[$month_counter].'2', $totalPaper)
                ->setCellValue($cell_counter[$month_counter].'3', $totalElectronicOPACURLs)
                ;
            $month_counter++;
            
            $phpExcelObject->getActiveSheet()->setTitle("Usage");
            $num_sheets++; //increment our num_sheets counter
        }
        
        // Generate processing stats.
        if(in_array('processing', $reportOptions)){
            //Holdings totals variables
            $totalWeeklyRecordsAdded = 0;
            $totalMonthlyRecordsAdded = 0;
            $totalMonthlyNonOverlays = 0;
            
            $phpExcelObject->createSheet($num_sheets); //create a new sheet.
            $phpExcelObject->setActiveSheetIndex($num_sheets);
            
            $this->__getGovDocsCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A2', "Weekly Records Added")
                    ->setCellValue('A3', "Monthly Records Added")
                    ->setCellValue('A4', "Monthly Non-Overlays")
                    ;
            
            //Populate the data for each category for each month of the year
            $cell_counter = range('B','Z');
            $month_counter = 0;
            while($month_counter < 12){
                // Sometimes no record will exsit for a given month. If that's the case, set all values for that month to 0.
                if($data[$month_counter] == null){
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'2', 0)
                        ->setCellValue($cell_counter[$month_counter].'3', 0)
                        ->setCellValue($cell_counter[$month_counter].'4', 0)
                        ;
                } else {
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'2', $data[$month_counter]->getWeeklyRecordsAdded())
                        ->setCellValue($cell_counter[$month_counter].'3', $data[$month_counter]->getMonthlyRecordsAdded())
                        ->setCellValue($cell_counter[$month_counter].'4', $data[$month_counter]->getMonthlyNonOverlays())
                        ;
                    
                    $totalWeeklyRecordsAdded += $data[$month_counter]->getWeeklyRecordsAdded();
                    $totalMonthlyRecordsAdded += $data[$month_counter]->getMonthlyRecordsAdded();
                    $totalMonthlyNonOverlays += $data[$month_counter]->getMonthlyNonOverlays();
                }
                $month_counter++;
            }
            
            //Totals
            $phpExcelObject->getActiveSheet()
                ->setCellValue($cell_counter[$month_counter].'2', $totalWeeklyRecordsAdded)
                ->setCellValue($cell_counter[$month_counter].'3', $totalMonthlyRecordsAdded)
                ->setCellValue($cell_counter[$month_counter].'4', $totalMonthlyNonOverlays)
                ;
            $month_counter++;
            
            $phpExcelObject->getActiveSheet()->setTitle("Processing");
            $num_sheets++; //increment our num_sheets counter
        }
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);
       
        // Create a Excel5 and create a StreamedResponse.
        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);
        
        // Add headers.
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            "govdocs_".$reportType.'_'.$reportYear.'_'.date("Y_m_d_His").".xls"
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        
        return $response;
    }
    
    /**
     * Add header rows to a GOVDOCS CSV.
     * 
     * @param \PHPExcel $phpExcelObject 
     * @param String $reportType  Either 'fiscal' or 'calendar'
     * @param mixed $reportYear  The year (either in format 'year1' or 'year1-year2')
     * @return false
     */
    private function __getGovDocsCSVHeaders(\PHPExcel $phpExcelObject, $reportType, $reportYear){
        if($reportType == 'calendar'){
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('B1', "Jan " . $reportYear)
                    ->setCellValue('C1', "Feb " . $reportYear)
                    ->setCellValue('D1', "Mar " . $reportYear)
                    ->setCellValue('E1', "Apr " . $reportYear)
                    ->setCellValue('F1', "May " . $reportYear)
                    ->setCellValue('G1', "Jun " . $reportYear)
                    ->setCellValue('H1', "Jul " . $reportYear)
                    ->setCellValue('I1', "Aug " . $reportYear)
                    ->setCellValue('J1', "Sep " . $reportYear)
                    ->setCellValue('K1', "Oct " . $reportYear)
                    ->setCellValue('L1', "Nov " . $reportYear)
                    ->setCellValue('M1', "Dec " . $reportYear)
                    ->setCellValue('N1', "TOTAL")
                    ;    
        }

        if($reportType == 'fiscal'){
            $years = explode('-', $reportYear);
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('B1', "Jul " . $years[0])
                    ->setCellValue('C1', "Aug " . $years[0])
                    ->setCellValue('D1', "Sep " . $years[0])
                    ->setCellValue('E1', "Oct " . $years[0])
                    ->setCellValue('F1', "Nov " . $years[0])
                    ->setCellValue('G1', "Dec " . $years[0])
                    ->setCellValue('H1', "Jan " . $years[1])
                    ->setCellValue('I1', "Feb " . $years[1])
                    ->setCellValue('J1', "Mar " . $years[1])
                    ->setCellValue('K1', "Apr " . $years[1])
                    ->setCellValue('L1', "May " . $years[1])
                    ->setCellValue('M1', "Jun " . $years[1])
                    ->setCellValue('N1', "TOTAL")
                    ;  
        }
        
        return;
    }
    
    /**
     * Get a record for a month for ANY type of monthly statistic entity
     * 
     * @param String $statsType  Either 'govdocs', 'map', 'periodical', or 'archives'
     * @param \DateTime $month
     * @return mixed  The entity that whose month matches the $month param, or null if no match was found.
     */
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
    
    /**
     * Return the first year in a string formatted "Year1-Year2"
     * 
     * @param String $year
     * @return String  The first part of the year string
     */
    private function __trimYear($year){
        $years = explode('-', $year);
        
        return $years[0];
    }
}

