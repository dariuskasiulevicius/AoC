<?php

namespace AdventOfCode\Year2023\Day03;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private array $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $this->map[] = str_split($item);
        }

        foreach ($this->map as $y => $line) {
            foreach ($line as $x => $char) {
                if ($char === '.' || is_numeric($char)) {
                    continue;
                }
                $result += array_sum($this->getNumbers($x, $y));
            }
        }

        return $result;
    }

    private function getNumbers($x, $y)
    {
        $offsets = [[-1, -1], [-1, 0], [0, -1], [1, 1], [0, 1], [1, 0], [-1, 1], [1, -1]];
        $max = count($this->map[0]);
        $numbers = [];
        foreach ($offsets as $offset) {
            if (is_numeric($this->map[$y + $offset[1]][$x + $offset[0]])) {
                $yNum = $y + $offset[1];
                $xNum = $x + $offset[0];
                $xMin = $xNum;
                $xMax = $xNum;
                for ($i = $xNum; $i >= 0; $i--) {
                    if (!is_numeric($this->map[$yNum][$i])) {
                        break;
                    }
                    $xMin = $i;
                }
                for ($i = $xNum; $i < $max; $i++) {
                    if (!is_numeric($this->map[$yNum][$i])) {
                        break;
                    }
                    $xMax = $i;
                }
                $num = '';
                for ($i = $xMin; $i <= $xMax; $i++) {
                    $num .= $this->map[$yNum][$i];
                    $this->map[$yNum][$i] = '.';
                }
                $numbers[] = (int)$num;
            }
        }

        return $numbers;
    }
}
