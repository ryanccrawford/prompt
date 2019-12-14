<?php

namespace Ryan\Benchmark;

use Exception;
use Ryan\Benchmark\Enum;

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
     * @param array $functions An array of callable functions.
     * @param int $cycles Number of times to benchmark each function.
     **/
    public function __construct(array $functions, int $cycles)
    {

        $this->functions = $functions;
        $this->cycles = $cycles;
    }

    public function getResults(): array
    {
        $results = [];

        foreach ($this->functions as $function) {
            $cycleCounter = 0;
            while ($cycleCounter < $this->cycles) {
                $cycleCounter++;
                $results['' . $function . ''][] = ['time' => $this->callFunction($function)];
            }
        }
        echo var_dump($results);
        return $results;
    }

    public function callFunction(callable $fn): float
    {
        $startTime = null;
        $endTime = null;
        try {
            $startTime = \microtime(true);
            $fn();
            $endTime = \microtime(true);
        } catch (Exception $ec) {
            throw $ec;
        }
        return ($endTime - $startTime);
    }
}
