<?php 

namespace Ryan\Benchmarker;

use Ryan\Benchmarker\Enum;


class Result {

    static $idCounter = -1;
    protected $id;
    public $timeToExecute;
    public $function;

    function __construct(float $timeToExecute, string $function)
    {
        $this->id = self::$idCounter++;
        $this->timeToExecute = $timeToExecute;
        $this->function = $function;
    }

}

class Results implements \Countable  {

    protected $results = [];

    public function addResult(\Ryan\Benchmarker\Result $result)
    {
        $this->results[] = $result;
    }

    public function count()
    {
        return count($this->results);
    }

    public function getNext() : \Ryan\Benchmarker\Result
    {
        return array_pop($this->results);
    } 

}


class Comparator {

    public $sortOrder;
    public $rankBy;
    public $benchmarkRes;

    function __construct( \Ryan\Benchmarker\Results $benchmarkRes, \Ryan\Benchmarker\Enum\Sort $sortOrder = 0, \Ryan\Benchmarker\Enum\Rank $rankBy = 0)
    {
        $this->benchmarkRes = $benchmarkRes;
        $this->sortOrder = $sortOrder;
        $this->rankBy = $rankBy;
    
    }

    public function rankBy(\Ryan\Benchmarker\Enum\Rank $rankType)
    {
        switch ($rankType) {
            case \Ryan\Benchmarker\Enum\Rank::Min :
              $this->min()
              break;
            case \Ryan\Benchmarker\Enum\Rank::Max :
              // do something
              break;
            case \Ryan\Benchmarker\Enum\Rank::Mean :
            // do something
             break;
            case \Ryan\Benchmarker\Enum\Rank::avg :
                // do something
             break;
            default:
              // do something
        }


    }

    public function min(){
       
        $holderResults = new Results();
        foreach($this->benchmarkRes as $key => $val){
            
        }
    }

    public function max($a){

        return max($this->benchmarkRes);
    }

    public function avg($a){
        
        $totals = 0;
        $result = 0;

        if(\is_array($a)){
            foreach($a as $time){
                $totals += $time;
            }

            $numberOfItems = count($a);

            $result = $totals / $numberOfItems;
        }else{

            $result = $a;
        }

        return $result;


    }

    function mean($a, $b){

    }

    

}