# Benchmarker PHP CLI Application

Benchmark Project The objective of the project is to create an application which can benchmark the performance of a set of                   PHP functions and generate a report comparing the performance. 
 
Specifications: Components: Benchmark, Comparator, Reporter 
 
## Benchmarker
### Paramaters:
Accepts any number of callable functions.
Accepts an integer representing the number of times to execute each function.
Purpose:
The benchmark should execute each function the specified number of cycles and collect it's execution time in the highest possible time resolution and return a resultset which can be passed to the reporter component. 
 
## Comparator
The comparator is some criteria on which the functions will be ranked in relation to execution time (min, max, avg, mean, etc...).
TODO: Optionally it can also specify a sort order (ascending, descending). 
 
## Reporter
### Paramaters:
Accepts the results of the benchmarker.
Accepts and any number of comparators.
### Purpose:
It should generate a report which ranks the functions by the given comparators. The user should be able to specify a format for the results (template, eg.), outputing to stdout or disk

## How to Use

To get things runing, first clone the project 

```bash
$ git clone https://github.com/ryanccrawford/prompt
```

Next cd into folder and run composer. Then cd into the src folder.
```bash
$ cd prompt && composer install
$ cd src
```

you can create a file that has the functions you wanted to benchmark or create a list of callable names either way you run the cli appication like so.
```bash
$ php benchmark.php --functions=testfunctionsfile.php --cycles=20 --comparators=min,max --stdout

```
For help and a list of arguments you can pass
```bash
$ php benchmark.php --help
```
