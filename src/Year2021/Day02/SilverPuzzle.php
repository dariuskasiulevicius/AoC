<?php

namespace AdventOfCode\Year2021\Day02;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $h = 0;
        $d = 0;
        foreach ($inputData as $item) {
            [$action, $step] = explode(" ", $item);
            $step = (int)$step;
            if ($action === "forward") {
                $h += $step;
            } elseif ($action === "down") {
                $d += $step;
            } elseif ($action === "up") {
                $d -= $step;
            }
        }

        $result = $d * $h;

        return $result;
    }
}
