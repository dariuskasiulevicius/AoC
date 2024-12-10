<?php

namespace AdventOfCode\Year2024\Day10;

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
        $map = [];
        $xmax = 0;
        $ymax = 0;
        foreach ($inputData as $row => $item) {
            $y = $row - 1;
            $xmax = max($xmax, strlen($item));
            $ymax = max($ymax, $row);
            foreach (str_split($item) as $x => $char) {
                $map[$x . ';' . $y] = (int)$char;
            }
        }

        for ($y = 0; $y < $ymax; $y++) {
            for ($x = 0; $x < $xmax; $x++) {
                if ($map[$x . ';' . $y] === 0) {
                    $counts = $this->findPathsCount($x, $y, $map);
//                    var_export($counts);
//                    var_export(PHP_EOL);
                    $result += $counts;
                }
            }
        }

        return $result;
    }

    private function findPathsCount(int $x, int $y, array $map): int
    {
        $walks = [[$x, $y]];
        $paths = 0;
        $sides = [[0, -1], [1, 0], [0, 1], [-1, 0]];
        while (count($walks) > 0) {
            $newWalks = [];
            foreach ($walks as $walk) {
                if (isset($map[$walk[0] . ';' . $walk[1]]) && $map[$walk[0] . ';' . $walk[1]] === 9) {
                    $paths++;
                } elseif(isset($map[$walk[0] . ';' . $walk[1]])) {
                    foreach ($sides as $side) {
                        $newStep = [$walk[0] + $side[0], $walk[1] + $side[1]];
                        if (isset($map[$newStep[0] . ';' . $newStep[1]])
                            && $map[$newStep[0] . ';' . $newStep[1]] === $map[$walk[0] . ';' . $walk[1]] + 1) {
                            $newWalks[] = $newStep;
                        }
                    }
                }
            }
            $walks = $newWalks;
        }
        return $paths;
    }
}
