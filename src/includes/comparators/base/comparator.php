<?php

namespace Ryan\Benchmark\Comparators\Base;

/**
 * Comparator abstract class
 */
abstract class ComparatorAbstract
{

    /** @var string $name */
    public $name;
    /** @var Type $returnType */
    public $returnType;
}

/**
 * ComparatorBase interface
 */
interface ComparatorBase
{
    /**
     * calculate method
     *
     * Must take any array of numbers
     * 
     * Create a function that applies a set of operations on 
     * the array of numbers and returns a single number
     *
     * @param Array $numbers An Array of numbers 
     * @return float Returns a single float 
     **/
    public function calculate(array $numbers);
}
