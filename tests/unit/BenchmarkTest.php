<?php
$lang = 'en';

//load includes

require_once('../../src/includes/comparators/base/comparator.php');
require_once('../../src/includes/reporter.php');
require_once('../../src/includes/benchmarker.php');

use \Ryan\Benchmark;
use PHPUnit\Framework\TestCase;

class BenchmarkerTest extends TestCase
{

    // tests
    public function testBenchmarker()
    {
        include('../../src/testfunctionsfile.php');
        $functionNames = ['f1', 'f2', 'f3'];
        $cycles = 20;

        $benchMarker = new \Ryan\Benchmark\Benchmarker($functionNames, $cycles);
        $this->assertInstanceOf('\Ryan\Benchmark\Benchmarker', $benchMarker);

        $this->assertCount(3,  $benchMarker->getResults());
    }
}
