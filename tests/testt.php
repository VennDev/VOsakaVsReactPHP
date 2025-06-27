<?php

$array = range(1, 1000000);

$start = microtime(true);
$count = count($array);
for ($i = 0; $i < $count; $i++) {
    $array[$i] = $i + 1;
}
echo "Method 2: " . (microtime(true) - $start);

$start = microtime(true);
foreach ($array as $k => $v) {
    $array[$k] = $v + 1;
}
echo "Method 1: " . (microtime(true) - $start);

//Method 2: 0.018215894699097
//Method 1: 0.038440942764282
