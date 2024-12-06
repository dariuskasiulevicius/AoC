<?php

namespace AdventOfCode\Year2024\Day05;

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
                for ($j = $i + 1; $j < $count; $j++) {
                    if (!$this->valid($map, $page[$i], $page[$j])) {
                        $valid = false;
                        break 2;
                    }
                }
            }
            if (!$valid) {
                $reordered = $this->reorder($page, $map);
//                var_export($page);
//                var_export($reordered);
                $key = ($count + 1) / 2 - 1;
                $result += $reordered[$key];
            }
        }

        return $result;
    }

    private function valid($map, $x, $y)
    {
        return !isset($map[$x][$y]);
    }

    private function reorder($page, $map): array
    {
        $count = count($page);
        do {
            $didAction = false;
            for ($i = 0; $i < $count; $i++) {
                $reordered = [];
                for ($k = 0; $k <= $i; $k++) {
                    $reordered[] = $page[$k];
                }
                for ($j = $i + 1; $j < $count; $j++) {
                    if ($this->valid($map, $page[$i], $page[$j])) {
                        $reordered[] = $page[$j];
                    } else {
                        unset($reordered[$i]);
                        $reordered[] = $page[$j];
                        $reordered[] = $page[$i];
                        for ($k = $j + 1; $k < $count; $k++) {
                            $reordered[] = $page[$k];
                        }
                        $didAction = true;
                        $page = array_values($reordered);
                        break 2;
                    }
                }
                $page = array_values($reordered);
            }

        } while ($didAction);

        return $page;
    }
}
