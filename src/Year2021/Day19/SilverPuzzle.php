<?php

namespace AdventOfCode\Year2021\Day19;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $scanners = [];
        $beacons = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if (strpos($item, 'scanner') !== false) {
                if (!empty($beacons)) {
                    $scanners[] = $beacons;
                    $beacons = [];
                }
            } elseif (!empty($item)) {
                $beacons[] = array_map('intval', explode(',', $item));
            }
        }
        if (!empty($beacons)) {
            $scanners[] = $beacons;
            $beacons = [];
        }

        list($fullScanners, $fullBeacons) = $this->getFullMap($scanners);


        return count($fullBeacons);
    }

    /**
     * @param array $scanners
     * @return array
     */
    public function getFullMap(array $scanners): array
    {
        $fullScanners = [];
        $first = array_shift($scanners);
        $fullBeacons = $first;
        $fullScanners[] = [0, 0, 0];

        while (!empty($scanners)) {
            $first = array_shift($scanners);
            $scanner = $this->hasIdenticalVectors($fullBeacons, $first);
            if ($scanner === false) {
                $scanners[] = $first;
            } else {
                $fullBeacons = $this->addNewBeacons($fullBeacons, $scanner[1], $scanner[0]);
                $fullScanners[] = $scanner[0];
            }
        }

        return array($fullScanners, $fullBeacons);
    }

    private function addNewBeacons(array $fullBeacons, array $newBeacons, array $modifier)
    {
        foreach ($newBeacons as $newBeacon) {
            $point = [
                $newBeacon[0] + $modifier[0],
                $newBeacon[1] + $modifier[1],
                $newBeacon[2] + $modifier[2],
            ];
            $fullBeacons[] = $point;
        }
        $cache = [];
        $filteredBeacons = [];
        foreach ($fullBeacons as $beacon) {
            $key = implode(';', $beacon);
            if (!isset($cache[$key])) {
                $filteredBeacons[] = $beacon;
                $cache[$key] = true;
            }
        }

        return $filteredBeacons;
    }

    private function hasIdenticalVectors($fullMap, $newPoints)
    {
        $mapVectors = $this->getVectors($fullMap);
        $vars = $this->getAllVariationsOfScanners($newPoints);
        foreach ($vars as $var) {
            $newVectors = $this->getVectors($var);
            $count = [];
            foreach ($mapVectors as $aPointNum => $bPoints) {
                foreach ($bPoints as $bPointNum => $bPoint) {
                    foreach ($newVectors as $cPointNum => $dPoints) {
                        foreach ($dPoints as $dPointNum => $dPoint) {
                            if ($dPoint === $bPoint) {
                                $count[$aPointNum] = $cPointNum;
                                $count[$bPointNum] = $dPointNum;
                            }
                        }
                    }
                }
            }
            if (count($count) >= 11) {
                $bPoint = reset($count);
                $aPoint = key($count);

                return [
                    [
                        $fullMap[$aPoint][0] - $var[$bPoint][0],
                        $fullMap[$aPoint][1] - $var[$bPoint][1],
                        $fullMap[$aPoint][2] - $var[$bPoint][2],
                    ],
                    $var,
                ];
            }
        }

        return false;
    }

    private function getAllVariationsOfScanners($points)
    {
        $vars = [];
        foreach ($points as $point) {
            foreach ($this->getAllVariations($point) as $key => $variation) {
                $vars[$key][] = $variation;
            }
        }

        return $vars;
    }

    private function getVectors($nodes)
    {
        $vectors = [];
        $count = count($nodes);
        foreach ($nodes as $i => $node) {
            for ($j = $i + 1; $j < $count; $j++) {
                $vectors[$i][$j] = array_map(function ($a, $b) {
                    return $b - $a;
                }, $node, $nodes[$j]);
            }
        }

        return $vectors;
    }

    private function getAllVariations(array $point): array
    {
        $points = [];
        $rotateZ = [
            [0, -1, 0],
            [1, 0, 0],
            [0, 0, 1],
        ];
        $rotateY = [
            [0, 0, 1],
            [0, 1, 0],
            [-1, 0, 0],
        ];
        $rotateX = [
            [1, 0, 0],
            [0, 0, -1],
            [0, 1, 0],
        ];
        $rotations = [
            $rotateX,
            $rotateX,
            $rotateX,
            $rotateY,
            $rotateX,
            $rotateX,
            $rotateX,
            $rotateY,
            $rotateX,
            $rotateX,
            $rotateX,

            $rotateY,
            $rotateX,
            $rotateX,
            $rotateX,
            $rotateY,
            $rotateX,
            $rotateX,
            $rotateX,
            $rotateY,
            $rotateX,
            $rotateX,
            $rotateX,
        ];

        foreach ($rotations as $key => $rotation) {
            $point = $this->rotate($point, $rotation);
            $points[] = $point;
            if ($key === 10) {
                $point = $this->rotate($point, $rotateY);
                $point = $this->rotate($point, $rotateX);
                $point = $this->rotate($point, $rotateY);
            }
        }

        return $points;
    }

    private function rotate(array $point, array $rotate): array
    {
        $rotated = [];
        foreach ($rotate as $key => $item) {
            $rotated[$key] = array_sum(
                array_map(function ($a, $b) {
                    return $a * $b;
                }, $item, $point)
            );
        }

        return $rotated;
    }
}
