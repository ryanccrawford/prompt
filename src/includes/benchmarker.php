<?php

namespace Ryan\Benchmarker;

use Exception;
use SebastianBergmann\CodeCoverage\Report\Xml\Report as XmlReport;
use \SplEnum;

class Benchmarker {

    

    public $resultSet;
    

    /**
     * Benchmarker Constructor 
     *
     * Creates an instance of the Benchmarker Class
     *
     * @param array $functions An array of callable functions.
     * @param int $cycles Number of times to benchmark each function.
     **/
    public function __construct(array $functions, int $cycles)
    {
        
        $this->$functions = $functions;
        $this->$cycles = $cycles;

    }

    public function addFunction(callable $function)
    {
        
        $this->functions[] = $function;

    }


} 

class Benchmark {

    protected $functions = [];
    protected $cycles = 0;
    protected $report;

     /**
     * Benchmarker Constructor 
     *
     * Creates an instance of the Benchmarker Class
     *
     * @param array $functions An array of callable functions.
     * @param int $cycles Number of times to benchmark each function.
     **/
    public function __construct(array $functions, int $cycles)
    {
        
        $this->functions = $functions;
        $this->cycles = $cycles;
        $this->reporter = new Reporter;

    }

    public function start() 
    {
        $results = [];

        foreach($this->functions as $function){
            
            $startTime = \microtime(true);
            $function();
            $endTime = \microtime(true);
            $executionTime = ($endTime - $startTime);
            $results[] = ['name' => '$function', 'time' => $executionTime];
        }

        $this->reporter = new Reporter($results);
        
    }

}





/**
 * Reporter: Used to create a collection of reports 
 * from the results of benchmarker
 */
class Reporter {

    protected $resultSet;
    protected $format;
    protected $comparators = [];
    /**
     * Reporter Constructor 
     *
     * Creates an instance of the Reporter Class
     *
     * @param array $resultSet An array of Results.
     * @param array $comparators An array of Comparators.
     * @param string $format indicates the type of output format to use. 
     * @param int $cycles Number of times to benchmark each function.
     **/
    public function __construct($resultSet, $comparators, $format = 'stdout')
    {
        if(!$resultSet || !$comparators){
            throw new Exception('Must initiate using benchmark result set, and a comparator');
        }
            $this->resultSet = $resultSet;
            $this->comparators = $comparators;
            $this->format = $format; 
    }

    public function createReport()
    {
        switch($this->format){
            case 'stdout':
                $this->stdOut()
        }

    }

    function stdOut(s)
    {

    }

    function toDisk($fileName, $stream)
    {


    }

}

class Report {

    public $benchmarkResult;
    public $format;
    public $comparators = [];

     /**
     * Benchmarker Constructor 
     *
     * Creates an instance of the Benchmarker Class
     *
     * @param array $functions An array of callable functions.
     * @param int $cycles Number of times to benchmark each function.
     **/
    public function __construct()
    {
        
       

    }

}