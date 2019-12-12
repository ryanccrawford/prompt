<?php

namespace Ryan\Benchmarker;

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
    protected $times = [];

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

    public function start() : \Ryan\Benchmarker\Reporter
    {
        $result = [];

        foreach($this->functions as $function){
            
            $startTime = \microtime(true);
            $function();
            $endTime = \microtime(true);
            $executionTime = ($endTime - $startTime);
            $result[] = ['name' => '$function', 'time' => $executionTime];
        }

        
    }

}





/**
 * Reporter: Used to create a collection of reports 
 * from the results of benchmarker
 */
class Reporter {

   

     /**
     * Reporter Constructor 
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