<?php

namespace Ryan\Benchmark\Comparators;

use Ryan\Benchmark\Comparators\Base\ComparatorBase;
use Ryan\Benchmark\Comparators\Base\ComparatorAbstract;

class ComparatorMin extends ComparatorAbstract implements ComparatorBase
{

    public function calculate(array $numbers)
    {
        return min($numbers);
    }
}
