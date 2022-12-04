<?php

namespace AdventOfCode\Year2022\Day04;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $segments = explode(',', $item);
            if ($this->intersect($segments[0], $segments[1]) || $this->intersect($segments[1], $segments[0])) {
                $result++;
            }
        }

        return $result;
    }

    private function intersect($left, $right)
    {
        $result = false;
        $leftSegments = explode('-', $left);
        $rightSegments = explode('-', $right);

        if (
            ($leftSegments[0] >= $rightSegments[0] && $leftSegments[0] <= $rightSegments[1])
            || ($leftSegments[1] >= $rightSegments[0] && $leftSegments[1] <= $rightSegments[1])
        ) {
            $result = true;
        }

        return $result;
    }
}
