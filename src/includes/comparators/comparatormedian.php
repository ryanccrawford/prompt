<?php

namespace Ryan\Benchmark\Comparators;

use Ryan\Benchmark\Comparators\Base\ComparatorBase;
use Ryan\Benchmark\Comparators\Base\ComparatorAbstract;

class ComparatorMedian extends ComparatorAbstract implements ComparatorBase
{

    public function calculate(array $numbers)
    {
        $numberOfCycles = count($numbers);
        rsort($numbers);
        $middle = round($numberOfCycles / 2, 2);
        $median =  $numbers[$middle - 1];
        return $median;
    }
}
