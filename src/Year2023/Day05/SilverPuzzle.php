<?php

namespace AdventOfCode\Year2023\Day05;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $seeds = [];
        $maps = [];
        foreach ($inputData as $item) {
            if (empty($seeds) && is_numeric($item[0])) {
                $seeds = array_map('intval', explode(' ', $item));
            } elseif (!empty($seeds)) {
                if (empty($item)) {
                    if (!empty($newMap)) {
                        $maps[] = $newMap;
                    }
                    $newMap = [];
                } elseif (is_numeric($item[0])) {
                    $newMap[] = array_map('intval', explode(' ', $item));
                }
            }

        }
        if (!empty($newMap)) {
            $maps[] = $newMap;
        }

        $modifiedSeeds = $seeds;
        foreach ($maps as $map) {
            foreach ($modifiedSeeds as $key => $modifiedSeed) {
                $modifiedSeeds[$key] = $this->transformByMap($modifiedSeed, $map);
            }
        }
        $result = min($modifiedSeeds);

        return $result;
    }

    protected function transformByMap($source, $maps)
    {
        foreach ($maps as $map) {
            if ($map[1] <= $source && $source <= ($map[1] + $map[2] -1 )) {
                return $source - $map[1] + $map[0];
            }
        }

        return $source;
    }
}
