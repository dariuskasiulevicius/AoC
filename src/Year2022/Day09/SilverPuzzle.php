<?php

namespace AdventOfCode\Year2022\Day09;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $hx = 0;
        $hy = 0;
        $tMap = [];
        $tx = 0;
        $ty = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            [$action, $size] = explode(' ', $item);
            while ($size > 0) {
                switch ($action) {
                    case 'R':
                        $hx++;
                        break;
                    case 'L':
                        $hx--;
                        break;
                    case 'U':
                        $hy++;
                        break;
                    case 'D':
                        $hy--;
                        break;
                }
                if ($hy === $ty) {
                    if ($hx - 1 === $tx + 1) {
                        $tx++;
                    } elseif ($hx + 1 === $tx - 1) {
                        $tx--;
                    }
                } elseif ($hx === $tx) {
                    if ($hy - 1 === $ty + 1) {
                        $ty++;
                    } elseif ($hy + 1 === $ty - 1) {
                        $ty--;
                    }
                } elseif (!$this->pointIsInRectangle($tx, $ty, $hx - 1, $hx + 1, $hy - 1, $hy + 1)) {
                    if ($this->pointIsInRectangle($tx + 1, $ty + 1, $hx - 1, $hx + 1, $hy - 1, $hy + 1)) {
                        $tx++;
                        $ty++;
                    } elseif ($this->pointIsInRectangle($tx + 1, $ty - 1, $hx - 1, $hx + 1, $hy - 1, $hy + 1)) {
                        $tx++;
                        $ty--;
                    } elseif ($this->pointIsInRectangle($tx - 1, $ty - 1, $hx - 1, $hx + 1, $hy - 1, $hy + 1)) {
                        $tx--;
                        $ty--;
                    } elseif ($this->pointIsInRectangle($tx - 1, $ty + 1, $hx - 1, $hx + 1, $hy - 1, $hy + 1)) {
                        $tx--;
                        $ty++;
                    }
                }
                $tMap[$ty][$tx] = 1;
                $size--;
            }
        }

        return array_sum(array_map('array_sum', $tMap));
    }

    private function pointIsInRectangle($x, $y, $lx, $rx, $dy, $uy)
    {
        $result = false;
        if ($x >= $lx && $x <= $rx && $y >= $dy && $y <= $uy) {
            $result = true;
        }

        return $result;
    }
}
