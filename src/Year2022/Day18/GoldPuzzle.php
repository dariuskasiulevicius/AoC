<?php

namespace AdventOfCode\Year2022\Day18;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private $map = [];
    private $sides = 0;
    private $minmax = [
        [null, null],
        [null, null],
        [null, null],
    ];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            //your custom code goes here
            $cube = explode(',', $item);
            $this->addToMap($cube);
            $this->addToMinMax($cube);
        }

        for ($x = $this->minmax[0][0]; $x <= $this->minmax[0][1]; $x++) {
            for ($y = $this->minmax[1][0]; $y <= $this->minmax[1][1]; $y++) {
                for ($z = $this->minmax[2][0]; $z <= $this->minmax[2][1]; $z++) {
                    $point = [$x, $y, $z];
                    if ($this->pointIsInside($point)) {
                        $this->addToMap($point);
                    }
                }
            }
        }

        return $this->sides;
    }

    private function addToMap($cube)
    {
        $key = implode(',', $cube);
        if (isset($this->map[$key])) {
            return;
        }
//        [$x, $y, $z] = $cube;
        $this->sides += 6;
        $this->map[$key] = '';

        $transformations = [
            [1, 0, 0], [-1, 0, 0],
            [0, 1, 0], [0, -1, 0],
            [0, 0, 1], [0, 0, -1],
        ];
        foreach ($transformations as $transformation) {
            $point = [
                $cube[0] + $transformation[0],
                $cube[1] + $transformation[1],
                $cube[2] + $transformation[2],
            ];
            $key = implode(',', $point);
            if (isset($this->map[$key])) {
                $this->sides -= 2;
            }
        }
    }

    private function addToMinMax($cube)
    {
        [$x, $y, $z] = $cube;
        if ($this->minmax[0][0] === null) {
            $this->minmax[0] = [$x, $x];
            $this->minmax[1] = [$y, $y];
            $this->minmax[2] = [$z, $z];
        }
        $this->minmax[0] = [min($this->minmax[0][0], $x), max($this->minmax[0][1], $x)];
        $this->minmax[1] = [min($this->minmax[1][0], $y), max($this->minmax[1][1], $y)];
        $this->minmax[2] = [min($this->minmax[2][0], $z), max($this->minmax[2][1], $z)];
    }

    private function pointIsInside($point)
    {
        [$x, $y, $z] = $point;

        //XX
        $edge = false;
        for ($xx = $x + 1; $xx <= $this->minmax[0][1]; $xx++) {
            $key = implode(',', [$xx, $y, $z]);
            if (isset($this->map[$key])) {
                $edge = true;
                break;
            }
        }
        if ($edge === false) {
            return false;
        }
        $edge = false;
        for ($xx = $x - 1; $xx >= $this->minmax[0][0]; $xx--) {
            $key = implode(',', [$xx, $y, $z]);
            if (isset($this->map[$key])) {
                $edge = true;
                break;
            }
        }
        if ($edge === false) {
            return false;
        }

        // YY
        $edge = false;
        for ($yy = $y + 1; $yy <= $this->minmax[1][1]; $yy++) {
            $key = implode(',', [$x, $yy, $z]);
            if (isset($this->map[$key])) {
                $edge = true;
                break;
            }
        }
        if ($edge === false) {
            return false;
        }
        $edge = false;
        for ($yy = $y - 1; $yy >= $this->minmax[1][0]; $yy--) {
            $key = implode(',', [$x, $yy, $z]);
            if (isset($this->map[$key])) {
                $edge = true;
                break;
            }
        }
        if ($edge === false) {
            return false;
        }

        // ZZ
        $edge = false;
        for ($zz = $z + 1; $zz <= $this->minmax[2][1]; $zz++) {
            $key = implode(',', [$x, $y, $zz]);
            if (isset($this->map[$key])) {
                $edge = true;
                break;
            }
        }
        if ($edge === false) {
            return false;
        }
        $edge = false;
        for ($zz = $z - 1; $zz >= $this->minmax[2][0]; $zz--) {
            $key = implode(',', [$x, $y, $zz]);
            if (isset($this->map[$key])) {
                $edge = true;
                break;
            }
        }
        if ($edge === false) {
            return false;
        }

        return true;
    }
}
