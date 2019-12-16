<?php
/*
 * Title: Benchmarker
 * Version: 1.0.0 - RTC
 * CLI Application
 * Created: 12-13-2019 
 * Author: Ryan Crawford
 * Email: ryanccrawford@live.com
*/

namespace Ryan\Benchmark;

use Exception;

class Benchmarker
{

    protected $functions = [];
    protected $cycles = 0;
    protected $report;


    /**
     * Benchmarker Constructor 
     *
     * Creates an instance of the Benchmarker Class
     *
     * @param array $functions An array of callables.
     * @param int $cycles Optional. Number of times to run a benchmark on each callable.
     **/
    public function __construct(array $functions, int $cycles = 1)
    {
        $this->functions = $functions;
        $this->cycles = $cycles;
    }

    /**
     * getResults() method 
     *
     * Generates benchmarks and Returns the result set as an array
     * @return array 
     **/
    public function getResults(): array
    {
        $results = [];

        foreach ($this->functions as $function) {
            $cycleCounter = 0;
            while ($cycleCounter < $this->cycles) {
                $cycleCounter++;
                $results[$function][] = ['time' => $this->callFunction($function)];
            }
        }
        return $results;
    }

    protected function callFunction(callable $fn): float
    {
        $startTime = null;
        $endTime = null;
        try {
            $startTime = doubleval(microtime(true));
            $fn();
            $endTime = doubleval(microtime(true));
        } catch (Exception $ec) {
            throw $ec;
            exit;
        }
        $totalTime = doubleval(($endTime * 1000) - ($startTime * 1000)); //Milliseconds Sec

        return  $totalTime;
    }
}
