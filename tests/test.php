<?php

use venndev\vosaka\time\Sleep;
use venndev\vosaka\VOsaka;

require '../vendor/autoload.php';


function benchVosakaBasicTasks(): void
{
    VOsaka::spawn(vosakaBasicTasksGenerator());
    VOsaka::run();
}

function basicTask(int $id): Generator
{
    yield Sleep::c(0);
    return $id;
}

function vosakaBasicTasksGenerator(): Generator
{
    $tasks = [];
    for ($i = 0; $i < 2; $i++) {
        $tasks[] = VOsaka::spawn(basicTask($i));
    }

    yield from VOsaka::join(...$tasks)();
}

benchVosakaBasicTasks();