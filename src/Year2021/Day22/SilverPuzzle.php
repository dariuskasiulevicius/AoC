<?php

namespace AdventOfCode\Year2021\Day22;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $data = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            [$position, $coordinates] = explode(" ", $item);
            $on = false;
            if ($position === 'on') {
                $on = true;
            }
            preg_match('/x=(-*\d*)..(-*\d*),y=(-*\d*)..(-*\d*),z=(-*\d*)..(-*\d*)/', $coordinates, $matches);
            $row = [
                'on' => $on,
                'x'  => [$matches[1], $matches[2]],
                'y'  => [$matches[3], $matches[4]],
                'z'  => [$matches[5], $matches[6]],
            ];
            $data[] = $row;
        }

        $limit = ['x' => [-50, 50], 'y' => [-50, 50], 'z' => [-50, 50]];
        $buffer = [];
        foreach ($data as $item) {
            $x = $item['x'];
            $y = $item['y'];
            $z = $item['z'];
            if ($x[0] <= $limit['x'][1] && $x[1] >= $limit['x'][0]
                && $y[0] <= $limit['y'][1] && $y[1] >= $limit['y'][0]
                && $z[0] <= $limit['z'][1] && $z[1] >= $limit['z'][0]) {
                $fromX = max($x[0], $limit['x'][0]);
                $toX = min($x[1], $limit['x'][1]);
                $fromY = max($y[0], $limit['y'][0]);
                $toY = min($y[1], $limit['y'][1]);
                $fromZ = max($z[0], $limit['z'][0]);
                $toZ = min($z[1], $limit['z'][1]);
                for ($i = $fromZ; $i <= $toZ; $i++) {
                    for ($j = $fromY; $j <= $toY; $j++) {
                        for ($k = $fromX; $k <= $toX; $k++) {
                            $key = implode(';', [$k, $j, $i]);
                            if ($item['on']) {
                                $buffer[$key] = true;
                            } elseif (isset($buffer[$key])) {
                                unset($buffer[$key]);
                            }
                        }
                    }
                }
            }
        }

        return count($buffer);
    }
}
