# game-of-life

Quite simple implementation of Conway's Game of Life in PHP.

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$gameOfLife = new \Tamiroh\GameOfLife\GameOfLife([
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 1, 0, 0, 0, 0],
    [0, 0, 0, 1, 1, 0, 0],
    [0, 0, 1, 1, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 1, 0, 0, 0],
    [0, 0, 0, 1, 0, 0, 0],
    [0, 0, 0, 1, 0, 0, 0],
]);

while (true) {
    ($gameOfLife = $gameOfLife->next())->print();
    echo '-----------' . PHP_EOL;
    usleep(200000);
}
```