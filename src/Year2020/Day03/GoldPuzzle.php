<?php

namespace AdventOfCode\Year2020\Day03;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result =
            $this->getTrees($inputData, 1, 1) *
            $this->getTrees($inputData, 3, 1) *
            $this->getTrees($inputData, 5, 1) *
            $this->getTrees($inputData, 7, 1) *
            $this->getTrees($inputData, 1, 2);


        return $result;
    }

    protected function getTrees($items, $step, $down)
    {
        $trees = 0;
        $line = 0;
        $positionLine = 0;
        foreach ($items as $item) {
            if ($line % $down === 0 && $line !== 0) {
                $positionLine++;
                $position = $positionLine * $step % strlen($item);
                if ($item[$position] === '#') {
                    $trees++;
                }
            }
            $line++;
        }

        return $trees;
    }
}
