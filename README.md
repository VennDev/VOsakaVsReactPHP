# VOsakaVsReactPHP
```
PHPBench (1.4.1) running benchmarks... #standwithukraine
with PHP version 8.4.8, xdebug ❌, opcache ❌

\CurlBench

    benchReactPhpCurl.......................I4 - Mo2.843s (±11.76%)
    benchVosakaCurl.........................I4 - Mo285.306ms (±26.81%)
    benchReactPhpMockRequests...............I4 - Mo714.688μs (±17.53%)
    benchVosakaMockRequests.................I4 - Mo941.371μs (±25.98%)
    benchReactPhpFastTasks..................I4 - Mo1.008ms (±3.63%)
    benchVosakaFastTasks....................I4 - Mo1.177ms (±4.16%)

Subjects: 6, Assertions: 0, Failures: 0, Errors: 0
+------+-----------+---------------------------+-----+------+------------+-----------------+--------------+----------------+
| iter | benchmark | subject                   | set | revs | mem_peak   | time_avg        | comp_z_value | comp_deviation |
+------+-----------+---------------------------+-----+------+------------+-----------------+--------------+----------------+
| 0    | CurlBench | benchReactPhpCurl         |     | 5    | 2,814,808b | 3,152,102.800μs | +1.00σ       | +11.76%        |
| 1    | CurlBench | benchReactPhpCurl         |     | 5    | 2,814,800b | 2,662,231.600μs | -0.48σ       | -5.61%         |
| 2    | CurlBench | benchReactPhpCurl         |     | 5    | 2,828,168b | 2,315,024.200μs | -1.52σ       | -17.92%        |
| 3    | CurlBench | benchReactPhpCurl         |     | 5    | 2,814,808b | 2,757,685.400μs | -0.19σ       | -2.22%         |
| 4    | CurlBench | benchReactPhpCurl         |     | 5    | 2,814,808b | 3,214,730.600μs | +1.19σ       | +13.98%        |
| 0    | CurlBench | benchVosakaCurl           |     | 5    | 1,073,704b | 272,690.200μs   | -0.70σ       | -18.77%        |
| 1    | CurlBench | benchVosakaCurl           |     | 5    | 1,073,704b | 222,797.200μs   | -1.25σ       | -33.64%        |
| 2    | CurlBench | benchVosakaCurl           |     | 5    | 1,073,704b | 305,144.400μs   | -0.34σ       | -9.11%         |
| 3    | CurlBench | benchVosakaCurl           |     | 5    | 1,073,704b | 466,630.400μs   | +1.45σ       | +39.00%        |
| 4    | CurlBench | benchVosakaCurl           |     | 5    | 1,073,704b | 411,324.000μs   | +0.84σ       | +22.52%        |
| 0    | CurlBench | benchReactPhpMockRequests |     | 5    | 990,544b   | 966.800μs       | +1.09σ       | +19.19%        |
| 1    | CurlBench | benchReactPhpMockRequests |     | 5    | 990,544b   | 682.400μs       | -0.91σ       | -15.87%        |
| 2    | CurlBench | benchReactPhpMockRequests |     | 5    | 990,544b   | 989.600μs       | +1.25σ       | +22.00%        |
| 3    | CurlBench | benchReactPhpMockRequests |     | 5    | 990,544b   | 769.200μs       | -0.30σ       | -5.17%         |
| 4    | CurlBench | benchReactPhpMockRequests |     | 5    | 990,544b   | 647.800μs       | -1.15σ       | -20.14%        |
| 0    | CurlBench | benchVosakaMockRequests   |     | 5    | 1,072,688b | 923.400μs       | -0.55σ       | -14.34%        |
| 1    | CurlBench | benchVosakaMockRequests   |     | 5    | 1,072,688b | 991.200μs       | -0.31σ       | -8.05%         |
| 2    | CurlBench | benchVosakaMockRequests   |     | 5    | 1,072,688b | 1,633.400μs     | +1.98σ       | +51.53%        |
| 3    | CurlBench | benchVosakaMockRequests   |     | 5    | 1,072,688b | 959.000μs       | -0.42σ       | -11.03%        |
| 4    | CurlBench | benchVosakaMockRequests   |     | 5    | 1,072,688b | 882.600μs       | -0.70σ       | -18.12%        |
| 0    | CurlBench | benchReactPhpFastTasks    |     | 5    | 1,702,728b | 996.400μs       | -0.80σ       | -2.88%         |
| 1    | CurlBench | benchReactPhpFastTasks    |     | 5    | 1,702,728b | 1,098.200μs     | +1.94σ       | +7.04%         |
| 2    | CurlBench | benchReactPhpFastTasks    |     | 5    | 1,702,728b | 1,011.000μs     | -0.40σ       | -1.46%         |
| 3    | CurlBench | benchReactPhpFastTasks    |     | 5    | 1,702,728b | 1,001.400μs     | -0.66σ       | -2.40%         |
| 4    | CurlBench | benchReactPhpFastTasks    |     | 5    | 1,702,728b | 1,023.000μs     | -0.08σ       | -0.29%         |
| 0    | CurlBench | benchVosakaFastTasks      |     | 5    | 1,072,624b | 1,214.400μs     | +0.46σ       | +1.92%         |
| 1    | CurlBench | benchVosakaFastTasks      |     | 5    | 1,072,624b | 1,272.400μs     | +1.63σ       | +6.79%         |
| 2    | CurlBench | benchVosakaFastTasks      |     | 5    | 1,072,624b | 1,173.000μs     | -0.37σ       | -1.55%         |
| 3    | CurlBench | benchVosakaFastTasks      |     | 5    | 1,072,624b | 1,173.800μs     | -0.36σ       | -1.48%         |
| 4    | CurlBench | benchVosakaFastTasks      |     | 5    | 1,072,624b | 1,123.800μs     | -1.36σ       | -5.68%         |
+------+-----------+---------------------------+-----+------+------------+-----------------+--------------+----------------+
```
