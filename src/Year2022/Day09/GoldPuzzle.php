<?php

namespace AdventOfCode\Year2022\Day09;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $rope = [];
        $ropeSize = 9;
        for ($i = 0; $i <= $ropeSize; $i++) {
            $rope[] = [0, 0];
        }
        $tMap = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            [$action, $size] = explode(' ', $item);
            while ($size > 0) {
                $rope[0] = $this->move($rope[0], $action);
                for ($i = 1; $i <= $ropeSize; $i++) {
                    $rope[$i] = $this->track($rope[$i - 1], $rope[$i]);
                }

                [$tx, $ty] = $rope[$ropeSize];
                $tMap[$ty][$tx] = 1;

                $size--;
            }
        }

        return array_sum(array_map('array_sum', $tMap));
    }

    private function move(array $point, string $side)
    {
        [$x, $y] = $point;
        switch ($side) {
            case 'R':
                $x++;
                break;
            case 'L':
                $x--;
                break;
            case 'U':
                $y++;
                break;
            case 'D':
                $y--;
                break;
        }

        return [$x, $y];
    }

    private function track(array $head, array $tail)
    {
        [$hx, $hy] = $head;
        [$tx, $ty] = $tail;
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
        return [$tx, $ty];
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
