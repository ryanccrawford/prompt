<?php

//Load Messages
include_once('./messages/' . $lang . '.php');
//Get command line options indexs
$help = array_search("--help", $argv);

//print help screen
if ($help) {
    echo HELP_MESSAGE;
    exit;
}

$numberOfArguments = count($argv);

$fileIndex = null;
$stdoutIndex  = null;
$testFunctionsIndex  = null;
$cyclesIndex  = null;
$comparatorsIndex  = null;
$options = [];
for ($i = 0; $i < $numberOfArguments; $i++) {


    if (stristr($argv[$i], '--file=') !== false) {
        $fileIndex = $i;
    }
    if (stristr($argv[$i], '--stdout') !== false) {
        $stdoutIndex = $i;
    }
    if (stristr($argv[$i], '--functions=') !== false) {
        $testFunctionsIndex = $i;
    }
    if (stristr($argv[$i], '--cycles=') !== false) {
        $cyclesIndex = $i;
    }
    if (stristr($argv[$i], '--comparators=') !== false) {
        $comparatorsIndex = $i;
    }
}

//Put command line options into a keyed array
$options = array(
    'file' => $fileIndex ? explode('=', $argv[$fileIndex])[1] : false,
    'stdout' => $stdoutIndex ? true : false,
    'functions' => $testFunctionsIndex ? explode('=', $argv[$testFunctionsIndex])[1] : false,
    'cycles' => $cyclesIndex ? intval(explode('=', $argv[$cyclesIndex])[1]) : 1,
    'comparators' => $comparatorsIndex ? explode(',', explode('=', $argv[$comparatorsIndex])[1]) : false
);

if (!isset($options['comparators'])) {
    echo ERROR_COMPARATOR;
    exit;
}

//Extract comparators from options and create an array of enum comparator->rank types
$comparators = [];
foreach ($options['comparators'] as $comparator) {
    $c = new \Ryan\Benchmark\Comparator();
    $type = 0;
    switch ($comparator) {
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
if (!$options['functions']) {
    echo ERROR_FUNCTIONS;
    exit;
}

//check to see if a php functions file exsist
if ($options['functions'] && !file_exists($options['functions'])) {
    echo ERROR_FUNCTIONS;
    exit;
}

//get list of function names in options function file
include($options['functions']);
$functionNames = getCallableFunctionsFromFile($options['functions']);

//check to see if file option was given and if that file exsist, will pass if no --file option used and will defualt to stdout
if ($options['file'] && !file_exists($options['file'])) {
    echo ERROR_FILE_EXISTS;
    exit;
}


//Functions

function getCallableFunctionsFromFile($file)
{

    $source = file_get_contents($file);
    $tokens = token_get_all($source);

    $functions = array();

    foreach ($tokens as $token) {
        switch ($token[0]) {
            case 319:
                $functions[] = $token[1];
                break;
        }
    }

    return $functions;
}
