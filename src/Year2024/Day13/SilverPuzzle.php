<?php

namespace AdventOfCode\Year2024\Day13;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $data = [];
        $game = [];
        foreach ($inputData as $item) {
            if (strpos($item, 'Button A: ') !== false) {
                $item = str_replace('Button A: ', '', $item);
                [$x, $y] = explode(', ', $item);
                $game['A'] = [
                    'x' => (int)str_replace('X+', '', $x),
                    'y' => (int)str_replace('Y+', '', $y)
                ];
            } elseif (strpos($item, 'Button B: ') !== false) {
                $item = str_replace('Button B: ', '', $item);
                [$x, $y] = explode(', ', $item);
                $game['B'] = [
                    'x' => (int)str_replace('X+', '', $x),
                    'y' => (int)str_replace('Y+', '', $y)
                ];
            } elseif (strpos($item, 'Prize: ') !== false) {
                $item = str_replace('Prize: ', '', $item);
                [$x, $y] = explode(', ', $item);
                $game['P'] = [
                    'x' => (int)str_replace('X=', '', $x),
                    'y' => (int)str_replace('Y=', '', $y)
                ];
            } else {
                $data[] = $game;
                $game = [];
            }
        }
        $data[] = $game;

        foreach ($data as $game) {
            $min = 500;
            for ($a = 1; $a <= 100; $a++) {
                for ($b = 1; $b <= 100; $b++) {
                    $x = $game['A']['x'] * $a + $game['B']['x'] * $b;
                    $y = $game['A']['y'] * $a + $game['B']['y'] * $b;
                    if ($x === $game['P']['x'] && $y == $game['P']['y']) {
                        $min = min($min, $a * 3 + $b * 1);
                    }
                }
            }
            if($min !== 500) {
                $result += $min;
            }
        }

        return $result;
    }
}
