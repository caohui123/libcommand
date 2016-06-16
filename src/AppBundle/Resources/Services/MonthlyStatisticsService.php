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
     * Generate a yearly report (fiscal or academic) for a monthly statistics category.
     * 
     * @param String $statsType  Either 'govdocs', 'maplibrary', 'periodical', or 'archives'
     * @param mixed $year
     * @param String $period
     * @return array $report  An array returning the results.
     */
    public function generateYearlyReport($statsType, $year, $period = 'fiscal'){
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
            
            $monthRecord[] = $this->__getMonthRecord($statsType, $nextMonth);
        }

        return $monthRecord;
    }
    
    /**
     * Create a series of Add/Edit tables on the Monthly Stats entity's index.html.twig page 
     * 
     * @param String $statsType  Either 'govdocs', 'maplibrary', 'periodical', or 'archives'
     * @param int $startYear  From what year should the tables be printed?
     * @return string $tables  The HTML table for the year.
     */
    public function monthlyTablesByYear($statsType, $startYear = 2015){
        switch($statsType){
            case 'govdocs':
                $path = 'monthly_govdocs';
                break;
            case 'maplibrary':
                $path = 'monthly_maplibrary';
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
            
            $this->__getCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
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
            
            $this->__getCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
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
            
            $this->__getCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
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
     * Create a CSV file for the given maplibrary data for either a fiscal or academic year.
     * 
     * @param String $reportType  Either 'fiscal' or 'academic'
     * @param String $reportYear 
     * @param type $reportOptions
     * @param array $data  Contains an array (ordered by month) of MonthlyStatsMapLibrary entities where applicable records are found; 
     *                     where applicable records are not found, null is present in that slot.   
     * @return StreamedResponse $response  A ready-to-go Symfony response which will generate the file when returned by a calling controller method.
     */
    public function assembleMapLibraryCSV($reportType, $reportYear, $reportOptions, $data){
        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();
        
        $phpExcelObject->getProperties()
                ->setCreator($this->container->get('security.context')->getToken()->getUser()->getUsername())
                ->setTitle('Map Library Statistics: ' . ucfirst($reportType) . ' Year ' . $reportYear)
                ;
        
        // Start writing the Excel file.
        $num_sheets = 0;
             
        // Generate holdings stats.
        if(in_array('holdings', $reportOptions)){
            //Holdings totals variables
            $totalMapsAdded = 0;
            $totalMapsWithdrawn = 0;
            $totalMaps = 0;
            $totalMaterialsAdded = 0;
            $totalMaterialsWithdrawn = 0;
            $totalMaterials = 0;
            
            //Excel file
            $phpExcelObject->setActiveSheetIndex($num_sheets);
            
            $this->__getCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A2', "Maps Added (gross)")
                    ->setCellValue('A3', "Maps Withdrawn")
                    ->setCellValue('A4', "Net Maps")
                        // skip row 5
                    ->setCellValue('A6', "Materials Added (gross)")
                    ->setCellValue('A7', "Materials Withdrawn")
                    ->setCellValue('A8', "Net Materials")
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
                            //skip row 5
                        ->setCellValue($cell_counter[$month_counter].'6', 0)
                        ->setCellValue($cell_counter[$month_counter].'7', 0)
                        ->setCellValue($cell_counter[$month_counter].'8', 0)
                        ;
                } else {
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'2', $data[$month_counter]->getMapsAddedGross())
                        ->setCellValue($cell_counter[$month_counter].'3', $data[$month_counter]->getMapsWithdrawn())
                        ->setCellValue($cell_counter[$month_counter].'4', ($data[$month_counter]->getMapsAddedGross() - $data[$month_counter]->getMapsWithdrawn()))
                            //skip row 5
                        ->setCellValue($cell_counter[$month_counter].'6', $data[$month_counter]->getMaterialsAddedGross())
                        ->setCellValue($cell_counter[$month_counter].'7', $data[$month_counter]->getMaterialsWithdrawn())
                        ->setCellValue($cell_counter[$month_counter].'8', ($data[$month_counter]->getMaterialsAddedGross() - $data[$month_counter]->getMaterialsWithdrawn()))
                        ;
                    
                    $totalMapsAdded += $data[$month_counter]->getMapsAddedGross();
                    $totalMapsWithdrawn += $data[$month_counter]->getMapsWithdrawn();
                    $totalMaps += ($totalMapsAdded - $totalMapsWithdrawn);
                    
                    $totalMaterialsAdded += $data[$month_counter]->getMaterialsAddedGross();
                    $totalMaterialsWithdrawn += $data[$month_counter]->getMaterialsWithdrawn();
                    $totalMaterials += ($totalMaterialsAdded - $totalMaterialsWithdrawn);
                }
                $month_counter++;
            }
            
            //Totals
            $phpExcelObject->getActiveSheet()
                ->setCellValue($cell_counter[$month_counter].'2', $totalMapsAdded)
                ->setCellValue($cell_counter[$month_counter].'3', $totalMapsWithdrawn)
                ->setCellValue($cell_counter[$month_counter].'4', ($totalMapsAdded - $totalMapsWithdrawn))
                    //skip row 5
                ->setCellValue($cell_counter[$month_counter].'6', $totalMaterialsAdded)
                ->setCellValue($cell_counter[$month_counter].'7', $totalMaterialsWithdrawn)
                ->setCellValue($cell_counter[$month_counter].'8', ($totalMaterialsAdded - $totalMaterialsWithdrawn))
                ;
            $month_counter++;
            
            $phpExcelObject->getActiveSheet()->setTitle("Holdings");
            $num_sheets++; //increment our num_sheets counter
        }
        
        // Generate usage stats.
        if(in_array('usage', $reportOptions)){
            //Holdings totals variables
            $totalItemsShelved = 0;
            $totalItemsAdded = 0;
            $totalItems = 0;
            
            $phpExcelObject->createSheet($num_sheets); //create a new sheet.
            $phpExcelObject->setActiveSheetIndex($num_sheets);
            
            $this->__getCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A2', "Items Shelved")
                    ->setCellValue('A3', "Items Added")
                    ->setCellValue('A4', "In-House Usage")
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
                        ->setCellValue($cell_counter[$month_counter].'2', $data[$month_counter]->getItemsShelved())
                        ->setCellValue($cell_counter[$month_counter].'3', $data[$month_counter]->getItemsAdded())
                        ->setCellValue($cell_counter[$month_counter].'4', ($data[$month_counter]->getItemsShelved() - $data[$month_counter]->getItemsAdded()))
                        ;
                    
                    $totalItemsShelved += $data[$month_counter]->getItemsShelved();
                    $totalItemsAdded += $data[$month_counter]->getItemsAdded();
                    $totalItems += ($totalItemsShelved - $totalItemsAdded);
                }
                $month_counter++;
            }
            
            //Totals
            $phpExcelObject->getActiveSheet()
                ->setCellValue($cell_counter[$month_counter].'2', $totalItemsShelved)
                ->setCellValue($cell_counter[$month_counter].'3', $totalItemsAdded)
                ->setCellValue($cell_counter[$month_counter].'4', ($totalItemsShelved - $totalItemsAdded))
                ;
            $month_counter++;
            
            $phpExcelObject->getActiveSheet()->setTitle("Usage");
            $num_sheets++; //increment our num_sheets counter
        }
        
        // Generate reference stats.
        if(in_array('reference', $reportOptions)){
            //Holdings totals variables
            $totalProcedureQuestion1 = 0;
            $totalProcedureQuestion3 = 0;
            $totalProcedureQuestion5 = 0;
            $totalProcedureQuestion10 = 0;
            $totalProcedureQuestion10Plus = 0;
            $totalResearchQuestion1 = 0;
            $totalResearchQuestion3 = 0;
            $totalResearchQuestion5 = 0;
            $totalResearchQuestion10 = 0;
            $totalResearchQuestion15 = 0;
            $totalResearchQuestion20 = 0;
            $totalResearchQuestion25 = 0;
            $totalResearchQuestion25Plus = 0;
            
            $phpExcelObject->createSheet($num_sheets); //create a new sheet.
            $phpExcelObject->setActiveSheetIndex($num_sheets);
            
            $this->__getCSVHeaders($phpExcelObject, $reportType, $reportYear); // Headers
            
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A2', "Directional/Procedural Questions")
                    ->setCellValue('A3', "1 Minute")
                    ->setCellValue('A4', "3 Minutes")
                    ->setCellValue('A5', "5 Minutes")
                    ->setCellValue('A6', "10 Minutes")
                    ->setCellValue('A7', ">10 Minutes")
                        //skip row 8
                    ->setCellValue('A9', "Research/Instructional Questions")
                    ->setCellValue('A10', "1 Minute")
                    ->setCellValue('A11', "3 Minutes")
                    ->setCellValue('A12', "5 Minutes")
                    ->setCellValue('A13', "10 Minutes")
                    ->setCellValue('A14', "15 Minutes")
                    ->setCellValue('A15', "20 Minutes")
                    ->setCellValue('A16', "25 Minutes")
                    ->setCellValue('A17', ">25 Minutes")
                    ;
            
            //Populate the data for each category for each month of the year
            $cell_counter = range('B','Z');
            $month_counter = 0;
            while($month_counter < 12){
                // Sometimes no record will exsit for a given month. If that's the case, set all values for that month to 0.
                if($data[$month_counter] == null){
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'3', 0)
                        ->setCellValue($cell_counter[$month_counter].'4', 0)
                        ->setCellValue($cell_counter[$month_counter].'5', 0)
                        ->setCellValue($cell_counter[$month_counter].'6', 0)
                        ->setCellValue($cell_counter[$month_counter].'7', 0)
                            //skip row 8,9
                        ->setCellValue($cell_counter[$month_counter].'10', 0)
                        ->setCellValue($cell_counter[$month_counter].'11', 0)
                        ->setCellValue($cell_counter[$month_counter].'12', 0)
                        ->setCellValue($cell_counter[$month_counter].'13', 0)
                        ->setCellValue($cell_counter[$month_counter].'14', 0)
                        ->setCellValue($cell_counter[$month_counter].'15', 0)
                        ->setCellValue($cell_counter[$month_counter].'16', 0)
                        ->setCellValue($cell_counter[$month_counter].'17', 0)
                        ;
                } else {
                    $phpExcelObject->getActiveSheet()
                        ->setCellValue($cell_counter[$month_counter].'3', $data[$month_counter]->getProcedureQuestion1())
                        ->setCellValue($cell_counter[$month_counter].'4', $data[$month_counter]->getProcedureQuestion3())
                        ->setCellValue($cell_counter[$month_counter].'5', $data[$month_counter]->getProcedureQuestion5())
                        ->setCellValue($cell_counter[$month_counter].'6', $data[$month_counter]->getProcedureQuestion10())
                        ->setCellValue($cell_counter[$month_counter].'7', $data[$month_counter]->getProcedureQuestion10Plus())
                            //skip row 8,9
                        ->setCellValue($cell_counter[$month_counter].'10', $data[$month_counter]->getResearchQuestion1())
                        ->setCellValue($cell_counter[$month_counter].'11', $data[$month_counter]->getResearchQuestion3())
                        ->setCellValue($cell_counter[$month_counter].'12', $data[$month_counter]->getResearchQuestion5())
                        ->setCellValue($cell_counter[$month_counter].'13', $data[$month_counter]->getResearchQuestion10())
                        ->setCellValue($cell_counter[$month_counter].'14', $data[$month_counter]->getResearchQuestion15())
                        ->setCellValue($cell_counter[$month_counter].'15', $data[$month_counter]->getResearchQuestion20())
                        ->setCellValue($cell_counter[$month_counter].'16', $data[$month_counter]->getResearchQuestion25())
                        ->setCellValue($cell_counter[$month_counter].'17', $data[$month_counter]->getResearchQuestion25Plus())
                        ;
                    
                    $totalProcedureQuestion1 += $data[$month_counter]->getProcedureQuestion1();
                    $totalProcedureQuestion3 += $data[$month_counter]->getProcedureQuestion3();
                    $totalProcedureQuestion5 += $data[$month_counter]->getProcedureQuestion5();
                    $totalProcedureQuestion10 += $data[$month_counter]->getProcedureQuestion10();
                    $totalProcedureQuestion10Plus += $data[$month_counter]->getProcedureQuestion10Plus();
                    
                    $totalResearchQuestion1 += $data[$month_counter]->getResearchQuestion1();
                    $totalResearchQuestion3 += $data[$month_counter]->getResearchQuestion3();
                    $totalResearchQuestion5 += $data[$month_counter]->getResearchQuestion5();
                    $totalResearchQuestion10 += $data[$month_counter]->getResearchQuestion10();
                    $totalResearchQuestion15 += $data[$month_counter]->getResearchQuestion15();
                    $totalResearchQuestion20 += $data[$month_counter]->getResearchQuestion20();
                    $totalResearchQuestion25 += $data[$month_counter]->getResearchQuestion25();
                    $totalResearchQuestion25Plus += $data[$month_counter]->getResearchQuestion25Plus();
                }
                $month_counter++;
            }
            
            //Totals
            $phpExcelObject->getActiveSheet()
                ->setCellValue($cell_counter[$month_counter].'3', $totalProcedureQuestion1)
                ->setCellValue($cell_counter[$month_counter].'4', $totalProcedureQuestion3)
                ->setCellValue($cell_counter[$month_counter].'5', $totalProcedureQuestion5)
                ->setCellValue($cell_counter[$month_counter].'6', $totalProcedureQuestion10)
                ->setCellValue($cell_counter[$month_counter].'7', $totalProcedureQuestion10Plus)
                    //skip row 8,9
                ->setCellValue($cell_counter[$month_counter].'10', $totalResearchQuestion1)
                ->setCellValue($cell_counter[$month_counter].'11', $totalResearchQuestion3)
                ->setCellValue($cell_counter[$month_counter].'12', $totalResearchQuestion5)
                ->setCellValue($cell_counter[$month_counter].'13', $totalResearchQuestion10)
                ->setCellValue($cell_counter[$month_counter].'14', $totalResearchQuestion15)
                ->setCellValue($cell_counter[$month_counter].'15', $totalResearchQuestion20)
                ->setCellValue($cell_counter[$month_counter].'16', $totalResearchQuestion25)
                ->setCellValue($cell_counter[$month_counter].'17', $totalResearchQuestion25Plus)
                ;
            $month_counter++;
            
            $phpExcelObject->getActiveSheet()->setTitle("Reference Statistics");
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
            "maplibrary_".$reportType.'_'.$reportYear.'_'.date("Y_m_d_His").".xls"
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        
        return $response;
    }
    
    /**
     * Add header rows to a monthly stats CSV.
     * 
     * @param \PHPExcel $phpExcelObject 
     * @param String $reportType  Either 'fiscal' or 'calendar'
     * @param mixed $reportYear  The year (either in format 'year1' or 'year1-year2')
     * @return false
     */
    private function __getCSVHeaders(\PHPExcel $phpExcelObject, $reportType, $reportYear){
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
     * @param String $statsType  Either 'govdocs', 'maplibrary', 'periodical', or 'archives'
     * @param \DateTime $month
     * @return mixed  The entity that whose month matches the $month param, or null if no match was found.
     */
    private function __getMonthRecord($statsType, \DateTime $month){
        
        switch($statsType){
            case 'govdocs':
                // Uses Symfony's QUERY BUILDER (as opposed to standard DQL queries)
                $repo = $this->em->getRepository('AppBundle\Entity\MonthlyStatsGovernmentDocuments');
                break;
            case 'maplibrary':
                $repo = $this->em->getRepository('AppBundle\Entity\MonthlyStatsMapLibrary');
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

