<?php
/*
 * Title: Benchmarker
 * Version: 1.0.0 - RTC
 * CLI Application
 * Created: 12-13-2019 
 * Author: Ryan Crawford
 * Email: ryanccrawford@live.com
*/
$numberOfArguments = count($argv);
$help = false;


if ($numberOfArguments < 2) {
    $help = true;
} else {
    $help = $argv[1] === '--help' ? true : false;
}

//print help screen
if ($help) {
    echo HELP_MESSAGE;
    exit;
}



$fileIndex = null;
$stdoutIndex  = null;
$testFunctionsIndex  = null;
$cyclesIndex  = null;
$comparatorsIndex  = null;
$options = [];
for ($i = 0; $i < $numberOfArguments; $i++) {


    if (stristr($argv[$i], '--file=') !== false) {
        $fileIndex = $i;
        continue;
    }
    if (stristr($argv[$i], '--stdout') !== false) {
        $stdoutIndex = $i;
        continue;
    }
    if (stristr($argv[$i], '--functions=') !== false) {
        $testFunctionsIndex = $i;
        continue;
    }
    if (stristr($argv[$i], '--cycles=') !== false) {
        $cyclesIndex = $i;
        continue;
    }
    if (stristr($argv[$i], '--comparators=') !== false) {
        $comparatorsIndex = $i;
        continue;
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

//Set Comparator names
$comparators = $options['comparators'];


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
