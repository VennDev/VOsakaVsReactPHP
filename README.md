# VOsakaVsReactPHP
```
PHPBench (1.4.1) running benchmarks... #standwithukraine
with PHP version 8.4.8, xdebug ❌, opcache ❌

\CurlBench

    benchReactPhpCurl.......................I4 - Mo3.662s (±9.74%)
    benchVosakaCurl.........................I4 - Mo2.660s (±5.98%)
    benchReactPhpMockRequests...............I4 - Mo387.076μs (±3.79%)
    benchVosakaMockRequests.................I4 - Mo329.967μs (±5.08%)
    benchReactPhpFastTasks..................I4 - Mo731.569μs (±3.79%)
    benchVosakaFastTasks....................I4 - Mo327.566μs (±26.11%)

Subjects: 6, Assertions: 0, Failures: 0, Errors: 0
+------+-----------+---------------------------+-----+------+------------+-----------------+--------------+----------------+
| iter | benchmark | subject                   | set | revs | mem_peak   | time_avg        | comp_z_value | comp_deviation |
+------+-----------+---------------------------+-----+------+------------+-----------------+--------------+----------------+
| 0    | CurlBench | benchReactPhpCurl         |     | 10   | 2,920,560b | 3,720,286.400μs | +0.55σ       | +5.36%         |
| 1    | CurlBench | benchReactPhpCurl         |     | 10   | 2,949,656b | 2,941,561.100μs | -1.71σ       | -16.69%        |
| 2    | CurlBench | benchReactPhpCurl         |     | 10   | 2,949,664b | 3,630,828.600μs | +0.29σ       | +2.83%         |
| 3    | CurlBench | benchReactPhpCurl         |     | 10   | 2,920,552b | 3,957,963.900μs | +1.24σ       | +12.09%        |
| 4    | CurlBench | benchReactPhpCurl         |     | 10   | 2,949,696b | 3,404,226.700μs | -0.37σ       | -3.59%         |
| 0    | CurlBench | benchVosakaCurl           |     | 10   | 980,672b   | 2,668,808.600μs | +0.56σ       | +3.32%         |
| 1    | CurlBench | benchVosakaCurl           |     | 10   | 980,672b   | 2,650,400.200μs | +0.44σ       | +2.61%         |
| 2    | CurlBench | benchVosakaCurl           |     | 10   | 980,672b   | 2,274,292.400μs | -2.00σ       | -11.95%        |
| 3    | CurlBench | benchVosakaCurl           |     | 10   | 980,672b   | 2,654,047.500μs | +0.46σ       | +2.75%         |
| 4    | CurlBench | benchVosakaCurl           |     | 10   | 980,672b   | 2,667,377.700μs | +0.55σ       | +3.27%         |
| 0    | CurlBench | benchReactPhpMockRequests |     | 10   | 983,544b   | 400.300μs       | +1.26σ       | +4.80%         |
| 1    | CurlBench | benchReactPhpMockRequests |     | 10   | 983,544b   | 357.800μs       | -1.67σ       | -6.33%         |
| 2    | CurlBench | benchReactPhpMockRequests |     | 10   | 983,544b   | 376.000μs       | -0.41σ       | -1.57%         |
| 3    | CurlBench | benchReactPhpMockRequests |     | 10   | 983,544b   | 391.300μs       | +0.64σ       | +2.44%         |
| 4    | CurlBench | benchReactPhpMockRequests |     | 10   | 983,544b   | 384.500μs       | +0.17σ       | +0.66%         |
| 0    | CurlBench | benchVosakaMockRequests   |     | 10   | 979,720b   | 355.000μs       | +1.52σ       | +7.75%         |
| 1    | CurlBench | benchVosakaMockRequests   |     | 10   | 979,720b   | 303.000μs       | -1.58σ       | -8.04%         |
| 2    | CurlBench | benchVosakaMockRequests   |     | 10   | 979,720b   | 327.800μs       | -0.10σ       | -0.51%         |
| 3    | CurlBench | benchVosakaMockRequests   |     | 10   | 979,720b   | 326.100μs       | -0.20σ       | -1.03%         |
| 4    | CurlBench | benchVosakaMockRequests   |     | 10   | 979,720b   | 335.500μs       | +0.36σ       | +1.83%         |
| 0    | CurlBench | benchReactPhpFastTasks    |     | 10   | 1,695,760b | 716.500μs       | -0.77σ       | -2.91%         |
| 1    | CurlBench | benchReactPhpFastTasks    |     | 10   | 1,695,760b | 782.200μs       | +1.58σ       | +5.99%         |
| 2    | CurlBench | benchReactPhpFastTasks    |     | 10   | 1,695,760b | 750.800μs       | +0.46σ       | +1.73%         |
| 3    | CurlBench | benchReactPhpFastTasks    |     | 10   | 1,695,760b | 738.900μs       | +0.03σ       | +0.12%         |
| 4    | CurlBench | benchReactPhpFastTasks    |     | 10   | 1,695,760b | 701.600μs       | -1.30σ       | -4.93%         |
| 0    | CurlBench | benchVosakaFastTasks      |     | 10   | 979,720b   | 562.000μs       | +1.86σ       | +48.66%        |
| 1    | CurlBench | benchVosakaFastTasks      |     | 10   | 979,720b   | 399.300μs       | +0.22σ       | +5.62%         |
| 2    | CurlBench | benchVosakaFastTasks      |     | 10   | 979,720b   | 318.700μs       | -0.60σ       | -15.70%        |
| 3    | CurlBench | benchVosakaFastTasks      |     | 10   | 979,720b   | 294.000μs       | -0.85σ       | -22.23%        |
| 4    | CurlBench | benchVosakaFastTasks      |     | 10   | 979,720b   | 316.200μs       | -0.63σ       | -16.36%        |
+------+-----------+---------------------------+-----+------+------------+-----------------+--------------+----------------+
```
