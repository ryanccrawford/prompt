<?php

namespace Ryan\Benchmark;

use Ryan\Benchmark\Enum\rank;
use Exception;

/**
 * Reporter: Used to create a collection of reports 
 * from the results of benchmarker
 */
class ReporterService {

    protected $benchmarkResults;
    protected $format;
    protected $comparators = [];
    protected $filePath = '';


    /**
     * setResultSet Setter 
     * Sets the internal $resultSet
     * @param array $resultSet a collection of Result
     * @return void
     **/
    public function setbenchmarkResults($resultSet) : void
    {
        if(!$resultSet){
            throw new Exception('Must provied an array of benchmark results');
        }
            $this->benchmarkResults = $resultSet;
    }

    /**
     * setComparators Setter 
     * Sets the internal $comparators
     * @param array $comparators a collection of Comparator
     * @return void
     **/
    public function setComparators($comparators) : void
    {
        if(!$comparators){
            throw new Exception('Must provied an array of comparators');
        }
            $this->comparators = $comparators;
    }

     /**
     * setformat Setter 
     * Sets the internal $format and $filePath
     * @param string $format either 'stdout' Defualt or 'file'
     * @param string $filePath path to file used to log output of report
     * @return void
     **/
    public function setformat($format = 'stdout', $filePath = '') : void
    {
        $this->format = $format; 
        $this->filePath = $filePath;
    }

    /**
     * sendReportStream method 
     * Sends the formated report using the the values set on this classes properties
     * @return void
     **/
    public function sendReportStream() : void
    {
        $report = new ReportType($this->createReportResponse());
        switch($this->format){
            case 'file':
                $this->toDisk($report);
            break;
            case 'stdout':
            default:
                $this->stdOut($report);
        }

    }

    /**
     * stdOut method 
     * Sends Report stream over stdOut   
     * @param ReportType $report
     * @return void
     **/
    public function stdOut(ReportType $report): void
    {
        echo  $report->toString();
    }

    /**
     * toDisk method 
     * Sends Report stream to disk   
     * @param ReportType $report
     * @return void
     **/
    public function toDisk(ReportType $report): void
    {
        $numberOfBytes = 0;

        try{

            $numberOfBytes = file_put_contents($this->filePath, $report->toString(), FILE_APPEND);
        }catch(Exception $exception)
        {
            echo 'Exception occured while trying to write to the file ' . $this->filePath . PHP_EOL . "Exception: " . $exception->getMessage() . PHP_EOL;
            return;
        }
        
       
       if($numberOfBytes === false){

        echo 'Error writting file ' . $this->filePath . PHP_EOL . "Error: Unkonown" . PHP_EOL;

       }else{

           echo 'File written to the file ' . $this->filePath . PHP_EOL . "Bytes written: " . $numberOfBytes . PHP_EOL;
       }

       return;

    }

     /**
     * createReportResponse method 
     * Creates a ReportResponse using properties $benchmarkResults and $comparators    
     * @return array
     **/
    public function createReportResponse() : array
    {
        $decoded_results = [];
      
        foreach($this->comparators as $comparator){
            foreach ($this->benchmarkResults as $functionName => $results) {
                $result = $this->doAction($comparator, $results);
                $decoded_results[$functionName] = [$result];
            }
        }
        
        return $decoded_results;
    }

     /**
     * doAction method 
     * Creates a a result using the given rank type on a list of benchmark execution times.accordion
     * @param \Ryan\Benchmark\Enum\rank $action 
     * @param array $timeList array of times as floats
     * @return array 
     **/
    public function doAction(\Ryan\Benchmark\Enum\rank $action, $timeList) : array
    {
        
        $result = [];
        $numberOfCycles = count($timeList);
       
            switch ($action) {

            case \Ryan\Benchmark\Enum\rank::Max:
                    $result['Maximum Time']  = max($timeList);
            break;
            case \Ryan\Benchmark\Enum\rank::Min:
                    $result['Minimun Time'] = min($timeList);
            break;
            case \Ryan\Benchmark\Enum\rank::Mean:
                    $result['Average Time'] = array_sum($timeList) / $numberOfCycles;
            break;
            case \Ryan\Benchmark\Enum\rank::Median:
                    rsort($timeList);
                    $middle = round($numberOfCycles, 2);
                    $median = $result[$middle-1];
                    $result['Median Time'] =  $median;
            break;
            case \Ryan\Benchmark\Enum\rank::Mode:
                    $countedValues = array_count_values($timeList);
                    asort($countedValues);
                    foreach ($countedValues as $k => $v) {
                        $result['Mode Time'] = $k;
                        break;
                    }
                    if(!$result['Mode Time']){
                        throw new Exception("Mode couldn't calculate");
                    }
            break;
            default:
                throw new Exception("Not a valid comparator");
        }
        

        return $result;

    }

}


/**
 * ReportType: Used to create a ReportType 
 * Used to convert reportServiceResponse to a formated string 
 * for output to screen or txt file
 */
class ReportType {

    protected $reportServiceResponse;
  
     /**
     * Report Constructor 
     *
     * Creates an instance of a ReportType
     *
     * @param array $reportServiceResponse An array of Key Value pairs created by a ReporterService.
     * @return ReportType
     **/
    public function __construct(array $reportServiceResponse)
    {
        $this->reportServiceResponse = $reportServiceResponse;
        
    }

    /**
     * toString() method 
     *
     * Creates at string containging the benchmarkreport created using reportServiceResponse property
     *
     * @param array $reportServiceResponse An array of Key Value pairs created by a ReporterService.
     * @return string 
     **/
    public function toString() : string
    {
       $stringToReturn = '--- Benchmark Report ---' . PHP_EOL;
       $stringToReturn = '========================' . PHP_EOL;
       foreach($this->reportServiceResponse as $key => $value){
           $stringToReturn .= $key . ": " . $value . PHP_EOL;
       }
       $stringToReturn = '========================' . PHP_EOL;

       return $stringToReturn;
       
    }

}