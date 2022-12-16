<?php

namespace AdventOfCode\Year2022\Day15;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private $draw = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $sensors = [];
        $beacons = [];
        $uniqBeacons = [];
        $distances = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if (false == preg_match_all('/x=(-?\d+), y=(-?\d+)/', $item, $matches)) {
                throw new \Exception('match not found');
            }

            $sensor = [(int)$matches[1][0], (int)$matches[2][0]];
            $beacon = [(int)$matches[1][1], (int)$matches[2][1]];
            $distance = abs($sensor[0] - $beacon[0]) + abs($sensor[1] - $beacon[1]);
            $sensors[] = $sensor;
            $beacons[] = $beacon;
            $uniqBeacons[$beacon[0] . ' ' . $beacon[1]] = $beacon;
            $distances[] = $distance;
        }

        $exists = [];
        $min = 0;
        $max = 4000000;
        foreach ($sensors as $key => $sensor) {
            [$x, $y] = $sensor;
            $rowMax = $y + $distances[$key];
            $rowMin = $y - $distances[$key];
            for ($yy = $rowMin; $yy <= $rowMax; $yy++) {
                if ($yy >= $min && $yy <= $max) {
                    $left = $distances[$key] - abs($yy - $y);
                    $new = [$x - $left, $x + $left];
//                $this->draw($line, $sensor, $new, $distances[$key]);
                    if (!isset($exists[$yy])) {
                        $exists[$yy] = [];
                    }
                    $exists[$yy] = $this->add($exists[$yy], $new);
                }
            }
        }

        $result = 0;
        $found = 0;
        foreach ($exists as $key => $exist) {
            if (count($exist) > 1) {
                $found++;
                $result += $key;
                $result += ($exist[0][1] + 1) * 4000000;
            }
        }
        echo $found;

        return $result;
    }

    private function sum($lines)
    {
        $result = 0;
        foreach ($lines as $exist) {
            $result += $exist[1] - $exist[0] + 1;
        }

        return $result;
    }

    private function add($lines, $newLine)
    {
        $add = true;
        foreach ($lines as $key => $line) {
            if ($newLine[1] >= $line[0] && $newLine[1] < $line[1] && $newLine[0] < $line[0]) {
                $lines[$key] = [$newLine[1] + 1, $line[1]];
            } elseif ($newLine[0] > $line[0] && $newLine[0] <= $line[1] && $newLine[1] > $line[1]) {
                $lines[$key] = [$line[0], $newLine[0] - 1];
            } elseif ($newLine[0] <= $line[0] && $newLine[1] >= $line[1]) {
                unset($lines[$key]);
            } elseif ($newLine[0] >= $line[0] && $newLine[1] <= $line[1]) {
                $add = false;
            }
        }
        if ($add) {
            $lines[] = $newLine;
        }
        sort($lines);

        $result = [];
        foreach ($lines as $line) {
            $last = array_pop($result);
            if (null !== $last && $last[1] + 1 == $line[0]) {
                $result[] = [$last[0], $line[1]];
            } else {
                if ($last !== null) {
                    $result[] = $last;
                }
                $result[] = $line;
            }
        }

        return $result;
    }

    private function draw($line, $sensor, $new, $distances)
    {
        echo 'Distances: ' . $distances . PHP_EOL;
        for ($y = 0; $y <= 30; $y++) {
            echo str_pad($y, 2, " ") . " ";
            for ($x = -30; $x <= 30; $x++) {
                if ($y === $line && $x >= $new[0] && $x <= $new[1]) {
                    echo '#';
                } elseif ($sensor[0] === $x && $sensor[1] === $y) {
                    echo 'S';
                } else {
                    echo '.';
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
