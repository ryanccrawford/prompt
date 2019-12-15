<?php

namespace Ryan\Benchmark\Comparators;

use Ryan\Benchmark\Comparators\Base\ComparatorBase;
use Ryan\Benchmark\Comparators\Base\ComparatorAbstract;

class ComparatorMax extends ComparatorAbstract implements ComparatorBase
{

    public function calculate(array $numbers)
    {
        return max($numbers);
    }
}
