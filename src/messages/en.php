<?php
/*
 * Title: Benchmarker
 * Version: 1.0.0 - RTC
 * CLI Application
 * Created: 12-13-2019 
 * Author: Ryan Crawford
 * Email: ryanccrawford@live.com
*/


//Messages
$help_messgae = 'benchmark.php is a cli php application that test the amount of time it takes to execute a function.' . PHP_EOL;
$help_messgae .=  'It will time each function in a file containing the said function an X amount of cycles, timming each one' . PHP_EOL;
$help_messgae .=  'Then using a given set of comparators, max min mean or mode, will create a report and send it to this output or to a file' . PHP_EOL;
$help_messgae .=  'Command line arguments:' . PHP_EOL;
$help_messgae .=  '--help                                        This Text' . PHP_EOL;
$help_messgae .=  '--functions=[path and filename]               A php file that contains the functions to test.' . PHP_EOL;
$help_messgae .=  '--stdout                                      Will Output Report to Screen' . PHP_EOL;
$help_messgae .=  '--file=[path and filename]                    Will Output Report to a File with the given name.' . PHP_EOL;
$help_messgae .=  '--cycles=[integer]                            The number of times to test each function, defultas to 1' . PHP_EOL;
$help_messgae .=  '--comparators=[min,max,mode,mean]             A list of comparators to use. Pick one or more seperated by a ,' . PHP_EOL;
$help_messgae .=  '' . PHP_EOL;
$help_messgae .=  'example:' . PHP_EOL;
$help_messgae .=  'php benchmark.php --file=testfunctions.php --cycles=20 --comparators=min|max --stdout' . PHP_EOL;
$help_messgae .=  '' . PHP_EOL;
$help_messgae .=  'Written by Ryan Crawford' . PHP_EOL;

define('HELP_MESSAGE', $help_messgae);
define('ERROR_COMPARATOR', "Please use at least one comparator type --comparators=max min mean mode" . PHP_EOL);
define('ERROR_FUNCTIONS', "Functions path and filename not found. Are you sure you used --functions=path\\filename.php" . PHP_EOL);
define('ERROR_FILE', "Could not find the file specified using the --file= option.  Make sure the file exists." . PHP_EOL);
define('ERROR_FILE_EXISTS', "Output file does not exists." . PHP_EOL);
