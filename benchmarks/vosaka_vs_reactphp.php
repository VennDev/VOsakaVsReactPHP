<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use PhpBench\Attributes as Bench;
use React\EventLoop\Factory as ReactFactory;
use React\Http\Browser;
use venndev\vosaka\VOsaka;
use venndev\vosaka\time\Sleep;

class CurlBench
{
    private array $testUrls = [
        'https://httpbin.org/delay/0',
        'https://httpbin.org/json',
        'https://httpbin.org/uuid',
    ];

    /**
     * Benchmark concurrent HTTP requests - ReactPHP
     */
    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    public function benchReactPhpCurl(): void
    {
        $loop = ReactFactory::create();
        $browser = new Browser($loop);
        $completed = 0;
        $total = count($this->testUrls);
        $errors = 0;

        foreach ($this->testUrls as $url) {
            $browser->get($url)
                ->then(function ($response) use (&$completed, $total, $loop) {
                    $completed++;
                    if ($completed >= $total) {
                        $loop->stop();
                    }
                })
                ->otherwise(function ($error) use (&$completed, $total, $loop, &$errors) {
                    $errors++;
                    $completed++;
                    if ($completed >= $total) {
                        $loop->stop();
                    }
                });
        }

        $loop->run();
    }

    /**
     * Benchmark concurrent HTTP requests - VOsaka
     */
    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    public function benchVosakaCurl(): void
    {
        VOsaka::spawn($this->vosakaCurlGenerator());
        VOsaka::run();
    }

    private function vosakaCurlGenerator(): Generator
    {
        $mh = curl_multi_init();
        $handles = [];
        $results = [];

        // Khởi tạo các yêu cầu cURL
        foreach ($this->testUrls as $index => $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_multi_add_handle($mh, $ch);
            $handles[$index] = $ch;
        }

        // Thực thi các yêu cầu đồng thời
        $running = null;
        do {
            $status = curl_multi_exec($mh, $running);
            if ($running > 0) {
                // Chờ I/O với timeout nhỏ
                yield Sleep::c(0.01); // 10ms
            }
        } while ($running > 0 && $status === CURLM_OK);

        // Lấy kết quả
        foreach ($handles as $index => $ch) {
            $result = curl_multi_getcontent($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);

            if ($result === false || !empty($error)) {
                $results[] = ['url' => $this->testUrls[$index], 'error' => $error ?: 'Unknown error'];
            } else {
                $results[] = [
                    'url' => $this->testUrls[$index],
                    'status' => $httpCode,
                    'size' => strlen($result)
                ];
            }

            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }

        curl_multi_close($mh);

        return $results;
    }

    /**
     * Benchmark local mock requests - ReactPHP
     */
    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    public function benchReactPhpMockRequests(): void
    {
        $loop = ReactFactory::create();
        $completed = 0;
        $total = 100;

        for ($i = 0; $i < $total; $i++) {
            $loop->futureTick(function () use (&$completed, $total, $loop, $i) {
                $mockResponse = json_encode(['id' => $i, 'data' => str_repeat('x', 100)]);
                $processed = json_decode($mockResponse, true);

                $completed++;
                if ($completed >= $total) {
                    $loop->stop();
                }
            });
        }

        $loop->run();
    }

    /**
     * Benchmark local mock requests - VOsaka
     */
    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    public function benchVosakaMockRequests(): void
    {
        VOsaka::spawn($this->vosakaMockGenerator());
        VOsaka::run();
    }

    private function vosakaMockGenerator(): Generator
    {
        $tasks = [];
        for ($i = 0; $i < 100; $i++) {
            $tasks[] = VOsaka::spawn($this->mockRequest($i));
        }

        yield from VOsaka::join(...$tasks)();
    }

    private function mockRequest(int $id): Generator
    {
        $mockResponse = json_encode(['id' => $id, 'data' => str_repeat('x', 100)]);
        return json_decode($mockResponse, true);
    }

    /**
     * Benchmark fast local requests - ReactPHP
     */
    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    public function benchReactPhpFastTasks(): void
    {
        $loop = ReactFactory::create();
        $completed = 0;
        $total = 1000;

        for ($i = 0; $i < $total; $i++) {
            $loop->futureTick(function () use (&$completed, $total, $loop, $i) {
                $data = ['id' => $i, 'result' => $i * 2];
                $completed++;
                if ($completed >= $total) {
                    $loop->stop();
                }
            });
        }

        $loop->run();
    }

    /**
     * Benchmark fast local requests - VOsaka
     */
    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    public function benchVosakaFastTasks(): void
    {
        VOsaka::spawn($this->vosakaFastGenerator());
        VOsaka::run();
    }

    private function vosakaFastGenerator(): Generator
    {
        $tasks = [];
        for ($i = 0; $i < 1000; $i++) {
            $tasks[] = VOsaka::spawn($this->fastTask($i));
        }

        yield from VOsaka::join(...$tasks)();
    }

    private function fastTask(int $id): Generator
    {
        return ['id' => $id, 'result' => $id * 2];
    }
}

// Simple and fast performance test
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    echo "Running performance comparison...\n\n";

    // Test 1: Mock requests (no network)
    echo "=== Test 1: Mock HTTP Processing (100 requests) ===\n";

    // ReactPHP mock test
    $start = microtime(true);
    $loop = ReactFactory::create();
    $completed = 0;
    $total = 100;

    for ($i = 0; $i < $total; $i++) {
        $loop->futureTick(function () use (&$completed, $total, $loop, $i) {
            $mockResponse = json_encode(['id' => $i, 'data' => str_repeat('x', 100)]);
            $processed = json_decode($mockResponse, true);
            $completed++;
            if ($completed >= $total) {
                $loop->stop();
            }
        });
    }

    $loop->run();
    $reactTime = microtime(true) - $start;
    echo "ReactPHP (100 mock requests): " . number_format($reactTime * 1000, 2) . "ms\n";

    // VOsaka mock test
    $start = microtime(true);
    VOsaka::spawn((function () {
        $tasks = [];
        for ($i = 0; $i < 100; $i++) {
            $tasks[] = VOsaka::spawn((function () use ($i) {
                $mockResponse = json_encode(['id' => $i, 'data' => str_repeat('x', 100)]);
                return json_decode($mockResponse, true);
            })());
        }
        yield from VOsaka::join(...$tasks)();
    })());
    VOsaka::run();
    $vosakaTime = microtime(true) - $start;
    echo "VOsaka (100 mock requests): " . number_format($vosakaTime * 1000, 2) . "ms\n";

    $improvement = (($reactTime - $vosakaTime) / $reactTime) * 100;
    echo "Difference: " . number_format($improvement, 1) . "% ";
    echo ($improvement > 0 ? "(VOsaka faster)" : "(ReactPHP faster)") . "\n\n";

    // Test 2: Real HTTP requests (3 URLs)
    echo "=== Test 2: Real HTTP Requests (3 URLs) ===\n";

    // ReactPHP real request
    $start = microtime(true);
    $loop = ReactFactory::create();
    $browser = new Browser($loop);
    $completed = 0;
    $total = count((new self)->testUrls);
    $errors = 0;

    foreach ((new self)->testUrls as $url) {
        $browser->get($url)
            ->then(function ($response) use (&$completed, $total, $loop) {
                $completed++;
                if ($completed >= $total) {
                    $loop->stop();
                }
            })
            ->otherwise(function ($error) use (&$completed, $total, $loop, &$errors) {
                $errors++;
                $completed++;
                if ($completed >= $total) {
                    $loop->stop();
                }
            });
    }

    $loop->run();
    $reactRealTime = microtime(true) - $start;
    echo "ReactPHP (3 real requests, $errors errors): " . number_format($reactRealTime * 1000, 2) . "ms\n";

    // VOsaka real request
    $start = microtime(true);
    VOsaka::spawn((function () {
        $mh = curl_multi_init();
        $handles = [];
        $results = [];
        $urls = (new CurlBench)->testUrls;

        foreach ($urls as $index => $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_multi_add_handle($mh, $ch);
            $handles[$index] = $ch;
        }

        $running = null;
        do {
            $status = curl_multi_exec($mh, $running);
            if ($running > 0) {
                yield Sleep::c(0.01);
            }
        } while ($running > 0 && $status === CURLM_OK);

        foreach ($handles as $index => $ch) {
            $result = curl_multi_getcontent($ch);
            $error = curl_error($ch);
            $results[] = $result ?: ['error' => $error ?: 'Unknown error'];
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }

        curl_multi_close($mh);
        return $results;
    })());
    VOsaka::run();
    $vosakaRealTime = microtime(true) - $start;
    echo "VOsaka (3 real requests): " . number_format($vosakaRealTime * 1000, 2) . "ms\n";

    $realImprovement = (($reactRealTime - $vosakaRealTime) / $reactRealTime) * 100;
    echo "Difference: " . number_format($realImprovement, 1) . "% ";
    echo ($realImprovement > 0 ? "(VOsaka faster)" : "(ReactPHP faster)") . "\n\n";

    // Test 3: Fast tasks (1000 tasks)
    echo "=== Test 3: Fast Tasks (1000 tasks) ===\n";

    // ReactPHP fast tasks
    $start = microtime(true);
    $loop = ReactFactory::create();
    $completed = 0;
    $total = 1000;

    for ($i = 0; $i < $total; $i++) {
        $loop->futureTick(function () use (&$completed, $total, $loop, $i) {
            $data = ['id' => $i, 'result' => $i * 2];
            $completed++;
            if ($completed >= $total) {
                $loop->stop();
            }
        });
    }

    $loop->run();
    $reactFastTime = microtime(true) - $start;
    echo "ReactPHP (1000 fast tasks): " . number_format($reactFastTime * 1000, 2) . "ms\n";

    // VOsaka fast tasks
    $start = microtime(true);
    VOsaka::spawn((function () {
        $tasks = [];
        for ($i = 0; $i < 1000; $i++) {
            $tasks[] = VOsaka::spawn((function () use ($i) {
                return ['id' => $i, 'result' => $i * 2];
            })());
        }
        yield from VOsaka::join(...$tasks)();
    })());
    VOsaka::run();
    $vosakaFastTime = microtime(true) - $start;
    echo "VOsaka (1000 fast tasks): " . number_format($vosakaFastTime * 1000, 2) . "ms\n";

    $fastImprovement = (($reactFastTime - $vosakaFastTime) / $reactFastTime) * 100;
    echo "Difference: " . number_format($fastImprovement, 1) . "% ";
    echo ($fastImprovement > 0 ? "(VOsaka faster)" : "(ReactPHP faster)") . "\n\n";

    echo "=== Summary ===\n";
    echo "Mock requests speed ratio: " . number_format($reactTime / $vosakaTime, 2) . "x\n";
    echo "Real requests speed ratio: " . number_format($reactRealTime / $vosakaRealTime, 2) . "x\n";
    echo "Fast tasks speed ratio: " . number_format($reactFastTime / $vosakaFastTime, 2) . "x\n";
}
?>