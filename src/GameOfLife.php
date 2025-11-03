<?php

declare(strict_types=1);

namespace Tamiroh\GameOfLife;

final class GameOfLife
{
    /**
     * @var list<list<CellState>>
     */
    public private(set) array $state;

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
            foreach (array_keys($columns) as $column) {
                $newState[$row][$column] = $this->nextCellState($row, $column);
            }
        }

        $this->state = $newState;

        return $this;
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