<?php

namespace AdventOfCode\Year2021\Day22;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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
                'c'  => [
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                    (int)$matches[4],
                    (int)$matches[5],
                    (int)$matches[6],
                ],
            ];
            $data[] = $row;
        }

        $cubes = [];
        foreach ($data as $item) {
            $cubesCount = count($cubes);
            [$x1, $x2, $y1, $y2, $z1, $z2] = $item['c'];
            for ($i = 0; $i < $cubesCount; $i++) {
                [$cx1, $cx2, $cy1, $cy2, $cz1, $cz2] = $cubes[$i];
                // not overlapping
                if ($x1 > $cx2 || $x2 < $cx1 || $y1 > $cy2 || $y2 < $cy1 || $z1 > $cz2 || $z2 < $cz1) {
                    continue;
                }
                unset($cubes[$i]);
                if ($x1 > $cx1) {
                    $cubes[] = [$cx1, $x1 - 1, $cy1, $cy2, $cz1, $cz2];
                }
                if ($x2 < $cx2) {
                    $cubes[] = [$x2 + 1, $cx2, $cy1, $cy2, $cz1, $cz2];
                }
                if ($y1 > $cy1) {
                    $cubes[] = [max($cx1, $x1), min($cx2, $x2), $cy1, $y1 - 1, $cz1, $cz2];
                }
                if ($y2 < $cy2) {
                    $cubes[] = [max($cx1, $x1), min($cx2, $x2), $y2 + 1, $cy2, $cz1, $cz2];
                }
                if ($z1 > $cz1) {
                    $cubes[] = [max($cx1, $x1), min($cx2, $x2), max($cy1, $y1), min($cy2, $y2), $cz1, $z1 - 1];
                }
                if ($z2 < $cz2) {
                    $cubes[] = [max($cx1, $x1), min($cx2, $x2), max($cy1, $y1), min($cy2, $y2), $z2 + 1, $cz2];
                }
            }

            if ($item['on']) {
                $cubes[] = $item['c'];
            }
            $cubes = array_values($cubes);
        }

//        echo 'Cube count ' . count($cubes) . PHP_EOL;
        $result = 0;
        foreach ($cubes as $cube) {
            [$x1, $x2, $y1, $y2, $z1, $z2] = $cube;
            $result += ($x2 - $x1 + 1) * ($y2 - $y1 + 1) * ($z2 - $z1 + 1);
        }

        return $result;
    }
}
