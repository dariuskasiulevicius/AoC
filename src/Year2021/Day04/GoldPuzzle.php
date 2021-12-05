<?php

namespace AdventOfCode\Year2021\Day04;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $draw = null;
        $tables = [];
        $table = null;
        foreach ($inputData as $item) {
            if (null === $draw) {
                $draw = array_map('intval', explode(",", $item));
            } elseif (!empty($item)) {
                $table->assign($item);
            } elseif (null !== $table) {
                $tables[] = $table;
                $table = new Model();
            } else {
                $table = new Model();
            }
        }
        $tables[] = $table;

        foreach ($draw as $item) {
            foreach ($tables as $nr => $table) {
                $table->markNumber($item);
            }
            do {
                [$winner, $tblNr] = $this->doWeHaveWinner($tables, $item);
                if (null !== $winner) {
                    $lastWinner = $winner;
                    $lastDraw = $item;
                    unset($tables[$tblNr]);
                }
            } while ($winner);
            if (empty($tables)) {
                break;
            }
        }

        return $lastWinner->leftSum() * $lastDraw;
    }

    /**
     * @param Model[] $tables
     * @return array{0: Model, 1: int}
     */
    private function doWeHaveWinner(array $tables): array
    {
        $winner = null;
        $tblNr = null;
        foreach ($tables as $nr => $table) {
            if ($table->isWinner()) {
                $winner = $table;
                $tblNr = $nr;
            }
        }

        return [$winner, $tblNr];
    }
}
