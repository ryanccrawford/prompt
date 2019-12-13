<?php

//load includes
require_once('../vendor/autoload.php');
require_once('./includes/enum.php');
require_once('./includes/comparator.php');
require_once('./includes/reporter.php');
require_once('./includes/benchmarker.php');

//Get command line options indexs
$fileIndex = array_search("--file=", $argv);
$stdoutIndex = array_search("--stdout", $argv);
$testFunctionsIndex = array_search("--functions=", $argv);
$cyclesIndex = array_search("--cycles=", $argv);
$comparatorsIndex = array_search("--comparators=", $argv);

//Put command line options into a keyed array
$options = array(
    'file' => $fileIndex ? explode('=', $argv[$fileIndex])[1] : false,
    'stdout' => $stdoutIndex ? true : false,
    'functions' => $testFunctionsIndex ? explode('=', $argv[$testFunctionsIndex])[1] : false,
    'cycles' => $cyclesIndex ? intval(explode('=', $argv[$cyclesIndex])[1]) : 1,
    'comparators' => $comparatorsIndex ? explode(' ', explode('=', $argv[$comparatorsIndex])[1]) : false
);

if(!is_array($options['comparators'])){
    echo "Please use at least one comparator type --comparators=max min mean mode" . PHP_EOL;
    exit;
}

//Extract comparators from options and create an array of enum comparator->rank types
$comparators = [];
foreach($options['comparators'] as $comparator){
    $c = new \Ryan\Benchmark\Comparator();
    $type = 0;
    switch($comparator){
        case 'max':
            $type = \Ryan\Benchmark\Enum\rank::Max;
        break;
        case 'min':
            $type = \Ryan\Benchmark\Enum\rank::Min;
        break;
        case 'mean':
            $type = \Ryan\Benchmark\Enum\rank::Mean;
        break;
        case 'mode':
            $type = \Ryan\Benchmark\Enum\rank::Mode;
        break;
    }
    $c->ranking_type = $type;
    $comparators[] = $c;
}

//check to see if a php functions file was given
if(!$options['functions']){
    echo "Functions path and filename not found. Are you sure you used --functions=path\\filename.php ?" . PHP_EOL;
    exit;
}

//check to see if a php functions file exsist
if($options['functions'] && !file_exists($options['functions'])){
    echo "Could not find the file, " . $options['functions'] . ", make sure the file exists." . PHP_EOL;
    exit;
}

//get list of function names in options function file
$functionNames = get_defined_functions_in_file($options['functions']);

//check to see if file option was given and if that file exsist, will pass if no --file option used and will defualt to stdout
if($options['file'] && !file_exists($options['file'])){
    echo "Output file does not exist." . PHP_EOL;
    exit;
}

//create instances of needed classes and start benchmarking
$benchMarker = new \Ryan\Benchmark\Benchmarker($functionNames, $options['cycles']);
$reporter = new \Ryan\Benchmark\ReporterService();
$benchmarkResults = $benchMarker->getResults();

$reporter->setbenchmarkResults($benchmarkResults);
$reporter->setComparators($comparators);
$reporter->setformat($options['stdout'], $options['file']);
$reporter->sendReportStream();
exit;

//Taken from Stack Exchange, Thank you Andrew Moore
//https://stackoverflow.com/questions/2197851/function-list-of-php-file/8728411

function get_defined_functions_in_file($file) {
    
    $source = file_get_contents($file);
    $tokens = token_get_all($source);

    $functions = array();
    $nextStringIsFunc = false;
    $inClass = false;
    $bracesCount = 0;

    foreach($tokens as $token) {
        switch($token[0]) {
            case T_CLASS:
                $inClass = true;
                break;
            case T_FUNCTION:
                if(!$inClass) $nextStringIsFunc = true;
                break;

            case T_STRING:
                if($nextStringIsFunc) {
                    $nextStringIsFunc = false;
                    $functions[] = $token[1];
                }
                break;

            // Anonymous functions
            case '(':
            case ';':
                $nextStringIsFunc = false;
                break;

            // Exclude Classes
            case '{':
                if($inClass) $bracesCount++;
                break;

            case '}':
                if($inClass) {
                    $bracesCount--;
                    if($bracesCount === 0) $inClass = false;
                }
                break;
        }
    }

    return $functions;
}