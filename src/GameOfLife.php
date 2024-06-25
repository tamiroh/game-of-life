<?php

namespace Tamiroh\GameOfLife;

readonly class GameOfLife
{
    /**
     * @var list<list<0|1>>
     */
    private array $state;

    /**
     * @param list<list<0|1>> $initialState
     */
    public function __construct(array $initialState = [[]])
    {
        $this->state = $initialState;
    }

    public function next(): self
    {
        $newState = $this->state;

        foreach ($this->state as $row => $columns) {
            foreach ($columns as $column => $cell) {
                $newState[$row][$column] = $this->nextCellState($row, $column);
            }
        }

        return new self($newState);
    }

    public function print(): void
    {
        ob_start();
        foreach ($this->state as $columns) {
            foreach ($columns as $cell) {
                echo $cell === 1 ? '🟥 ' : '⬜️ ';
            }
            echo PHP_EOL;
        }
        echo ob_get_clean();
    }

    private function nextCellState(int $row, int $column): int
    {
        $nearCells = [
            $this->state[$row - 1][$column - 1] ?? null,
            $this->state[$row - 1][$column] ?? null,
            $this->state[$row - 1][$column + 1] ?? null,
            $this->state[$row][$column - 1] ?? null,
            $this->state[$row][$column + 1] ?? null,
            $this->state[$row + 1][$column - 1] ?? null,
            $this->state[$row + 1][$column] ?? null,
            $this->state[$row + 1][$column + 1] ?? null,
        ];
        $countOfLivings = count(array_filter($nearCells, fn (int|null $v) => $v === 1));

        return $this->state[$row][$column] === 1
            ? (
                match (true) {
                    $countOfLivings <= 1, $countOfLivings >= 4 => 0,
                    $countOfLivings >=2 && $countOfLivings <= 3 => 1,
                }
            )
            : (
                $countOfLivings === 3
                    ? 1
                    : 0
            );
    }
}