<?php
// DISABLE WARNINGS
error_reporting(E_ERROR | E_PARSE);

// length of array, ((number)) of queries
list($length, $queriesCount) = listenToConsole(true);

// init. values to colorValueArray
$colorValueArray = array_fill(0, $length, ['color' => 1, 'value' => 0]);
$colorsExtraInfo = [
    1 => [
        'color' => 1,
        'indexesStart' => [0],
        'indexesEnd' => [$length - 1],
    ]
];

// array of details about available queries in problem #1638
$queryDetails =
    [
        'color' => [
            'name' => 'Color',
            'argument' => ['l', 'r', 'c'],
        ],
        'add' => [
            'name' => 'Add',
            'argument' => ['c', 'x'],
        ],
        'query' => [
            'name' => 'Query',
            'argument' => ['i'],
        ]
    ];

$output = [];

// HANDLE QUERIES SECTION
for ($counter = 1; $counter <= $queriesCount; $counter++) {
    list($query, $x, $y, $z) = listenToConsole(true);

    if($query && !in_array($query, array_pluck($queryDetails, 'name')) )
    {
        continue;
    } elseif(!$query) {
        continue;
    }

    switch ($query)
    {
        case 'Color':
            $l = $x;
            $r = $y;
            $c = $z;

            // COLOR QUERY
            $prevColor = $colorValueArray[$l - 1];

            if($c != $prevColor['color'] /*@TODO: add interruption conditions */) {
                $colorsExtraInfo[$prevColor['color']]['indexesEnd'][] = ($l - 1);
                $colorsExtraInfo[$prevColor['color']]['indexesStart'][] = ($r - 1);
            }

            // register color in related array
            $colorsExtraInfo[$c] = [
                'color' => $c,
            ];

            $colorsExtraInfo[$c]['indexesStart'][] = ($l - 1);
            $colorsExtraInfo[$c]['indexesEnd'][] = ($r - 1);

            for($j = $l; $j <= $r; $j++) {
                // change index color value
                $index = $j - 1;
                $colorValueArray[$index]['color'] = $c;
            }

            break;
        case 'Add':
            $c = $x;
            // reassign the value
            $x = $y;

            if(
                ! array_key_exists($c, array_pluck($colorValueArray, 'color'))
            ) {
                break;
            }

            $indexesStart = sort($colorsExtraInfo[$c]['indexesStart']);
            $indexesEnd = sort($colorsExtraInfo[$c]['indexesEnd']);

            $indexesCount = 0;
            for($loop = $indexesStart[$indexesCount]; $loop < $length; $loop++) {
                $colorValueArray[$loop]['value'] = $x;

                if($loop <= $indexesEnd[$indexesEnd])
                {
                    ++$indexesCount;
                    $loop = $indexesStart[$indexesCount];
                }
            }

            break;
        case 'Query':
            $i = $x;
            $output[] = $colorValueArray[$i - 1]['value'];
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
    foreach ($outputArray as $output)
    {
        echo $output . PHP_EOL;
    }
}
function array_pluck($array, $key) {
    return array_map(function($v) use ($key) {
        return is_object($v) ? $v->$key : $v[$key];
    }, $array);
}