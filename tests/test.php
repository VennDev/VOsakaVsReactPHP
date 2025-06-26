<?php

require '../vendor/autoload.php';

$array = [];

$promiseA = async(function () use (&$array) {
    sleep(2);
    $array[] = 1;
    return 'Task 1';
});

$promiseB = async(function () use (&$array) {
    sleep(2);
    $array[] = 2;
    return 'Task 2';
});

$time = microtime(true);
// just takes 2 seconds...
[$resA, $resB] = await([$promiseA, $promiseB]);

echo $resA; // Task 1
echo $resB; // Task 2

var_dump($array);
var_dump(microtime(true) - $time);
