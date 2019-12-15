<?php

namespace Ryan\Benchmark\Comparators;

use Ryan\Benchmark\Comparators\Base\ComparatorBase;
use Ryan\Benchmark\Comparators\Base\ComparatorAbstract;

class ComparatorMean extends ComparatorAbstract implements ComparatorBase
{

    public function calculate(array $numbers)
    {
        $sum = function ($num) {
            $sum = doubleval(0);
            foreach ($num as $value) {
                $sum += doubleval($value['time']);
            }
            return $sum;
        };
        $mean = $sum($numbers) / count($numbers);
        $returnMean = ['time' => $mean];
        return  $returnMean;
    }
}
