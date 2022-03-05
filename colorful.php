<?php
// DISABLE WARNINGS
error_reporting(E_ERROR | E_PARSE);

// length of array, ((number)) of queries
list($length, $queriesCount) = listenToConsole(true);

// init. values to colorValueArray
$colorValueArray = array_fill(0, $length, ['color' => 1, 'value' => 0]);

$output = [];

// HANDLE QUERIES SECTION
for ($counter = 1; $counter <= $queriesCount; $counter++) {
    list($query, $a, $b, $c) = listenToConsole(true);

    switch ($query) {
        case 'Color':
            $l = $a;
            $r = $b;

            for ($loop = $l - 1; $loop <= $r - 1; $loop++) {
                $colorValueArray[$loop]['color'] = $c;
            }

            break;
        case 'Add':
            // reassign
            $c = $a;
            $x = $b;

            foreach ($colorValueArray as &$colorValue) {
                if($colorValue['color'] != $c) {
                    continue;
                }

                $colorValue['value'] += $x;
            }

            /*
             * @TODO: CLEANUP
             * print_r($colorValueArray);
             * echo $x;
             */

            break;
        case 'Query':
            $output[] = $colorValueArray[$a - 1]['value'];
            break;
    }
}

// FINALLY OUTPUT
 printInConsole($output);

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

function printInConsole(array $outputArray)
{
    foreach ($outputArray as $output) {
        echo $output . PHP_EOL;
    }
}

function array_pluck($array, $key)
{
    return array_map(function ($v) use ($key) {
        return is_object($v) ? $v->$key : $v[$key];
    }, $array);
}