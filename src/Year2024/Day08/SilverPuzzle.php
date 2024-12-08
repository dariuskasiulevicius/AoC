<?php

namespace AdventOfCode\Year2024\Day08;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $towers = [];
        $map = [];
        $xmax = 0;
        $ymax = 0;
        foreach ($inputData as $y => $item) {
            $xmax = max($xmax, strlen($item));
            $ymax = max($ymax, $y);
            foreach (str_split($item) as $x => $char) {
                if ($char !== '.') {
                    if (!isset($towers[$char])) {
                        $towers[$char] = [];
                    }
                    $towers[$char][] = [$x, $y-1];
                    $map[$char][$x . ';' . $y-1] = true;
                }
            }
        }
        $signals = [];
        foreach ($towers as $char => $positions) {
            $count = count($positions);
            for ($i = 0; $i < $count; $i++) {
                for ($j = 0; $j < $count; $j++) {
                    if ($i === $j) {
                        continue;
                    }
                    $signals[$char][] = [$positions[$i][0] - $positions[$j][0] + $positions[$i][0], $positions[$i][1] - $positions[$j][1] + $positions[$i][1]];
                }
            }
        }
        $resultPerSignal = [];
        foreach ($signals as $char => $more) {
            foreach ($more as $signal) {
                $x = $signal[0];
                $y = $signal[1];
                if ($x >= 0 && $x < $xmax && $y >= 0 && $y < $ymax && !isset($map[$char][$x . ';' . $y])) {
                    $resultPerSignal[$x . ';' . $y] = '#';
                }
            }
        }
        $result = count($resultPerSignal);
        $this->printMap($resultPerSignal, $xmax, $ymax);

        return $result;
    }

    private function printMap($map, $xmax, $ymax)
    {
        for ($y = 0; $y < $ymax; $y++) {
            for ($x = 0; $x < $xmax; $x++) {
                echo $map[$x . ';' . $y] ?? '.';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
