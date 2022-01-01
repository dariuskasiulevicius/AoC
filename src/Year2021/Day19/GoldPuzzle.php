<?php

namespace AdventOfCode\Year2021\Day19;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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

        list($fullScanners, $fullBeacons) = (new SilverPuzzle())->getFullMap($scanners);

        $count = count($fullScanners);
        $max = 0;
        foreach ($fullScanners as $i => $scanner) {
            for ($j = $i + 1; $j < $count; $j++) {
                $distance = abs($scanner[0] - $fullScanners[$j][0]) +
                    abs($scanner[1] - $fullScanners[$j][1]) +
                    abs($scanner[2] - $fullScanners[$j][2]);
                $max = max($distance, $max);
            }
        }


        return $max;
    }
}
