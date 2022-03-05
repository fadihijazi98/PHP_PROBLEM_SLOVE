<?php
error_reporting(E_ERROR | E_PARSE);

include 'helper_functions.php';

printInConsole(
    [
        'Try Fib With memorize ? 0 means no, other yes',
    ]
);

$withMemorize = (bool) listenToConsole();
$fibN = 20;

$now = round(microtime(true) * 1000);

$result = $withMemorize ? fibWithMemorize($fibN) : fibWithoutMemorize($fibN);

printInConsole(
    [
    'RESULT: ' . $result,
    ],
    true,
    $now
);

function fibWithoutMemorize(int $n)
{
    if($n == 1) {
        return 1;
    } else if($n == 0) {
        return 0;
    }

    $nMinusTwo = $n - 1; $nMinusOne = $n - 2;
    printInConsole([
        "NUMBER: $n TIME TO CALLED fib($nMinusOne) and fib($nMinusTwo)"
    ]);

    return fibWithoutMemorize($nMinusOne) + fibWithoutMemorize($nMinusTwo);
}

function fibWithMemorize(int $n, array &$memory = [0, 1])
{
    if(! array_key_exists($n, $memory)) {
        $nMinusTwo = $n - 1; $nMinusOne = $n - 2;
        printInConsole([
            "NUMBER: $n TIME TO CALLED fib($nMinusOne, [..]) and fib($nMinusTwo, [..])"
        ]);

        $memory[$n] = fibWithMemorize($nMinusOne, $memory) + fibWithMemorize($nMinusTwo, $memory);
    }

    printInConsole([
        "NO NEED TO CALL fib($n), IS STORED = " . $memory[$n]
    ]);
    return $memory[$n];
}