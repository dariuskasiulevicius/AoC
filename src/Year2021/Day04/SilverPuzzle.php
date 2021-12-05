<?php

namespace AdventOfCode\Year2021\Day04;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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

            } elseif(!empty($item)) {
                $table->assign($item);
            } elseif(null !== $table) {
                $tables[] = $table;
                $table = new Model();
            } else {
                $table = new Model();
            }
        }
        $tables[] = $table;

        foreach ($draw as $item) {
            $winner = $this->doWeHaveWinner($tables, $item);
            if(null !== $winner) {
                break;
            }
        }

        return $winner->leftSum() * $item;
    }

    /**
     * @param Model[] $tables
     * @param int   $number
     * @return Model|null
     */
    private function doWeHaveWinner(array $tables, int $number): ?Model
    {
        $winner = null;
        foreach ($tables as $table) {
            $table->markNumber($number);
            if($table->isWinner()) {
                $winner = $table;
                break;
            }
        }

        return $winner;
    }
}
