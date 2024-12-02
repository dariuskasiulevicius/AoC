<?php

namespace AdventOfCode\Year2023\Day05;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $maps = [];
        $seedRanges = [];
        foreach ($inputData as $item) {
            if (empty($seedRanges) && is_numeric($item[0])) {
                $seedsRanges = array_map('intval', explode(' ', $item));
                $len = count($seedsRanges);
                for ($i = 0; $i < $len; $i = $i + 2) {
                    $seedRanges[] = [$seedsRanges[$i], $seedsRanges[$i] + $seedsRanges[$i + 1] - 1];
                }

            } elseif (!empty($seedRanges)) {
                if (empty($item)) {
                    if (!empty($newMap)) {
                        $maps[] = $newMap;
                    }
                    $newMap = [];
                } elseif (is_numeric($item[0])) {
                    [$destination, $source, $range] = array_map('intval', explode(' ', $item));
                    $newMap[] = [[$source, $source + $range - 1], [$destination, $destination + $range - 1]];
                }
            }

        }
        if (!empty($newMap)) {
            $maps[] = $newMap;
        }

        $modifiedSeeds = $seedRanges;
        foreach ($maps as $map) {
            $tmp = [];
            foreach ($modifiedSeeds as $key => $modifiedSeed) {
                $tmp = array_merge($tmp, $this->transformByMap($modifiedSeed, $map));
            }
            $modifiedSeeds = $tmp;
        }
        $result = PHP_INT_MAX;
        foreach ($modifiedSeeds as $modifiedSeed) {
            $result = min($result, min($modifiedSeed));
        }

        return $result;
    }

    protected function transformByMap($source, $maps)
    {
        $res = [];
        $items = [$source];
        do {
            $item = array_shift($items);
            $added = false;
            foreach ($maps as $map) {
                if ($item[0] < $map[0][0] && $item[1] >= $map[0][0]) {
                    $items[] = [$item[0], $map[0][0] - 1];
                    $item[0] = $map[0][0];
                }
                if ($item[1] > $map[0][1] && $item[0] <= $map[0][1]) {
                    $items[] = [$map[0][1] + 1, $item[1]];
                    $item[1] = $map[0][1];
                }
                if ($item[0] >= $map[0][0] && $item[1] <= $map[0][1]) {
                    $res[] = [$item[0] - $map[0][0] + $map[1][0], $item[1] - $map[0][0] + $map[1][0]];
                    $added = true;
                }
//            if ($map[1] <= $source && $source <= ($map[1] + $map[2] - 1)) {
//                return $source - $map[1] + $map[0];
//            }
            }
            if (!$added) {
                $res[] = $item;
            }
        } while (!empty($items));



        return $res;
    }
}
