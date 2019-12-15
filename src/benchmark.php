<?php
/*
 * Title: Benchmarker
 * Version: 1.0.0 - RTC
 * CLI Application
 * Created: 12-13-2019 
 * Author: Ryan Crawford
 * Email: ryanccrawford@live.com
*/

//Set Language
$lang = 'en';

//load includes
require_once('../vendor/autoload.php');
require_once('./includes/comparators/base/comparator.php');
require_once('./includes/reporter.php');
require_once('./includes/benchmarker.php');
require_once('./clioptions.php');


//Benckmark

//To Spec: Create Benchmarker that will take array of callables and number of cycles
$benchMarker = new \Ryan\Benchmark\Benchmarker($functionNames, $options['cycles']);
//Creates new Reporter Class
$reporter = new \Ryan\Benchmark\ReporterService();

//Gets benchmarker results
$benchmarkResults = $benchMarker->getResults();

//To Spec: Create Reporter that will take benchmark results
$reporter->setBenchmarkResults($benchmarkResults);
$reporter->setComparators($comparators);
$reporter->setFormat($options['stdout'], $options['file']);

//To Spec: Creates human readable report on I/O Steam to disk or stdout
$reporter->sendReportStream();
exit;
