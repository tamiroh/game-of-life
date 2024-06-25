<?php

declare(strict_types=1);

namespace Tamiroh\GameOfLife;

readonly class GameOfLife
{
    /**
     * @var list<list<CellState>>
     */
    private array $state;

    /**
     * @param list<list<0|1>> $initialState
     */
    public function __construct(array $initialState = [[]])
    {
        $this->state = array_map(
            fn (array $row) => array_map(
                fn (int $cell) => $cell === 1 ? CellState::Alive : CellState::Dead,
                $row
            ),
            $initialState
        );
    }

    public function next(): self
    {
        $newState = $this->state;

        foreach ($this->state as $row => $columns) {
            foreach ($columns as $column => $cell) {
                $newState[$row][$column] = match ($this->nextCellState($row, $column)) {
                    CellState::Alive => 1,
                    CellState::Dead => 0,
                };
            }
        }

        return new self($newState);
    }

    public function print(): void
    {
        ob_start();
        foreach ($this->state as $columns) {
            foreach ($columns as $cell) {
                echo $cell === CellState::Alive ? '🟥 ' : '⬜️ ';
            }
            echo PHP_EOL;
        }
        echo ob_get_clean();
    }

    private function nextCellState(int $row, int $column): CellState
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
        $countOfLivings = count(array_filter($nearCells, fn (?CellState $v) => $v === CellState::Alive));

        return $this->state[$row][$column] === CellState::Alive
            ? (
                match (true) {
                    $countOfLivings <= 1, $countOfLivings >= 4 => CellState::Dead,
                    $countOfLivings >=2 && $countOfLivings <= 3 => CellState::Alive,
                }
            )
            : (
                $countOfLivings === 3
                    ? CellState::Alive
                    : CellState::Dead
            );
    }
}