<?php

namespace AdventOfCode\Year2024\Day13;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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
                    'x' => 10000000000000 + (int)str_replace('X=', '', $x),
                    'y' => 10000000000000 + (int)str_replace('Y=', '', $y)
                ];
            } else {
                $data[] = $game;
                $game = [];
            }
        }
        $data[] = $game;

        foreach ($data as $game) {
            [$a, $b] = $this->getResult($game);
            if (is_int($a) && is_int($b)) {
                $result += $a * 3 + $b;
            }
        }

        return $result;
    }

    private function getResult(array $game): array
    {
        $ax = $game['A']['x'];
        $bx = $game['B']['x'];
        $ay = $game['A']['y'];
        $by = $game['B']['y'];
        $px = $game['P']['x'];
        $py = $game['P']['y'];

        $axBy = $ax * $by;
        $pxBy = $px * $by;

        $ayBx = $ay * $bx;
        $pyBx = $py * $bx;

        $a = ($pxBy - $pyBx) / ($axBy - $ayBx);
        $b = ($py - $ay * $a) / $by;

        return [$a, $b];
    }
}
