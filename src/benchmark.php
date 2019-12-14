<?php

//Set Language
$lang = 'en';

//load includes
require_once('../vendor/autoload.php');
require_once('./includes/enum.php');
require_once('./includes/comparator.php');
require_once('./includes/reporter.php');
require_once('./includes/benchmarker.php');
require_once('./clioptions.php');


//create instances of needed classes and start benchmarking
$benchMarker = new \Ryan\Benchmark\Benchmarker($functionNames, $options['cycles']);
$reporter = new \Ryan\Benchmark\ReporterService();
$benchmarkResults = $benchMarker->getResults();

$reporter->setbenchmarkResults($benchmarkResults);
$reporter->setComparators($comparators);
$reporter->setformat($options['stdout'], $options['file']);
$reporter->sendReportStream();
exit;
