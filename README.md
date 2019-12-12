# prompt

Benchmark Project The objective of the project is to create an application which can benchmark the performance of a set of                   PHP functions and generate a report comparing the performance. 
 
Specifications: Components: Benchmark, Comparator, Reporter 
 
Benchmark: The benchmarker should accept any number of PHP functions (passed as callable type and a name                representing the function).  
 
The benchmark should also accept an integer representing the number of times to execute each function.  
 
The benchmark should execute each function the specified number of cycles and collect it's execution               time in the highest possible time resolution and return a resultset which can be passed to the reporter                  component. 
 
Comparator: The comparator is some criteria on which the functions will be ranked in relation to execution time (min,                  max, avg, mean, etc...).  Optionally it can also specify a sort order (ascending, descending). 
 
Reporter: The reporter should accept the results of the benchmark and any number of comparators. It should                generate a report which ranks the functions by the given comparators. The user should be able to specify a format for the results (template, eg.) At a minimum the user should                    be able to write the report to an I/O stream (stdout or disk). 
