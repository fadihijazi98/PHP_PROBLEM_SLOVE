<?php

// HELPER FUNCTIONS
function listenToConsole($listOfInputs = false)
{
    $inputs =
        trim(
            fgets(
                STDIN,
                1024
            )
        );

    return $listOfInputs ? explode(' ', $inputs) : $inputs;
}

function printInConsole(array $outputArray, $timeTrack = false, $now = null)
{
    foreach ($outputArray as $output) {
        echo $output . PHP_EOL;
    }

    if($timeTrack && $now) {
        echo '__TIMER COST = ' . (round(microtime(true) * 1000) - $now) . ' milli second';
    }
}

function array_pluck($array, $key)
{
    return array_map(function ($v) use ($key) {
        return is_object($v) ? $v->$key : $v[$key];
    }, $array);
}