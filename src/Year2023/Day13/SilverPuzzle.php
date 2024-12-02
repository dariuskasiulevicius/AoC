<?php

namespace AdventOfCode\Year2023\Day13;

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
        $maps = [];
        $map = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if (empty($item)) {
                $maps[] = $map;
                $map = [];
            } else {
                $map[] = $item;
            }
        }
        $maps[] = $map;

        foreach ($maps as $map) {
            $col = $this->findFoldCol($map);
            if ($col > 0) {
                $result += $col;
            }
            $row = $this->findFoldRow($map);
            if ($row > 0) {
                $result += $row * 100;
            }
        }

        return $result;
    }

    private function findFoldCol(array $map): int
    {
        $lastCol = strlen($map[0]) - 1;
        $cols = [];
        for ($x = 0; $x <= $lastCol; $x++) {
            $colStr = '';
            foreach ($map as $line) {
                $colStr .= $line[$x];
            }
            $cols[] = md5($colStr);
        }

        return $this->findFoldNumber($cols);
    }

    private function findFoldRow(array $map): int
    {
        $rows = [];
        foreach ($map as $line) {
            $rows[] = md5($line);
        }
        return $this->findFoldNumber($rows);
    }

    private function findFoldNumber(array $hashes): int
    {
        $max = count($hashes) - 1;
        $res = -1;
        $prev = null;
        for ($i = 0; $i <= $max; $i++) {
            if ($prev === $hashes[$i]) {
                if ($this->checkIfValid($i - 1, $hashes)) {
                    $res = $i;
                    break;
                }
            }
            $prev = $hashes[$i];
        }
        return $res;
    }

    private function checkIfValid(int $point, array $hashes): bool
    {
        $res = true;
        $left = $point;
        $right = $point + 1;
        $max = count($hashes) - 1;
        while ($left >= 0 && $right <= $max) {
            if ($hashes[$left] !== $hashes[$right]) {
                $res = false;
                break;
            }
            $left--;
            $right++;
        }

        return $res;
    }
}
