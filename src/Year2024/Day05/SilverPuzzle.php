<?php

namespace AdventOfCode\Year2024\Day05;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $pages = [];
        $map = [];
        foreach ($inputData as $item) {
            if ($item === '') {
                continue;
            }
            if (strpos($item, ',') !== false) {
                $pages[] = explode(',', $item);
            }
            if (strpos($item, '|') !== false) {
                [$x, $y] = explode('|', $item);
                if (!isset($map[$y])) {
                    $map[$y] = [];
                }
                $map[$y][$x] = 1;
            }
        }

        foreach ($pages as $page) {
            $valid = true;
            $count = count($page);
            for ($i = 0; $i < $count; $i++) {
                for($j = $i + 1; $j < $count; $j++) {
                    if (!$this->valid($map, $page[$i], $page[$j])) {
                        $valid = false;
                        break 2;
                    }
                }
            }
            if ($valid) {
//                var_export($page);
                $key = ($count+1)/2-1;
//                var_export($key);
//                var_export($page[$key]);
                $result+=$page[$key];
            }
        }

        return $result;
    }

    private function valid($map, $x, $y)
    {
        return !isset($map[$x][$y]);
    }
}
