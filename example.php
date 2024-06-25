<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$gameOfLife = new \Tamiroh\GameOfLife\GameOfLife([
    [1, 0, 0, 0, 0, 0, 1],
    [1, 0, 1, 0, 0, 0, 0],
    [0, 0, 0, 1, 1, 0, 0],
    [0, 0, 1, 1, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 1, 0, 0, 0],
    [0, 0, 0, 1, 0, 0, 0],
    [0, 1, 0, 1, 0, 0, 0],
]);

while (true) {
    ($gameOfLife = $gameOfLife->next())->print();
    echo '-----------' . PHP_EOL;
    usleep(200000);
}