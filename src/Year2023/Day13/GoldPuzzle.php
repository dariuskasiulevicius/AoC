<?php

namespace AdventOfCode\Year2023\Day13;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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

        //51300 nieko nesake apie dydi
        //39800 per didelis
        //36755 teisingas
        //36400 per mazas
        //14100 per mazas

        foreach ($maps as $key => $map) {
            $row = $this->findFoldRow($map);
            if ($row > 0 ) {
                $result += $row * 100;
            }
            $col = $this->findFoldCol($map);
            if ($col > 0 ) {
                $result += $col;
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
            $cols[] = $colStr;
        }

        return $this->findFoldNumber($cols);
    }

    private
    function findFoldRow(array $map): int
    {
        return $this->findFoldNumber($map);
    }

    private
    function findFoldNumber(array $hashes): int
    {
        $max = count($hashes) - 1;
        $res = -1;
        $prev = null;
        for ($i = 0; $i <= $max; $i++) {
            if ($prev !== null && levenshtein($prev, $hashes[$i]) <= 1) {
                if ($this->checkIfValid($i - 1, $hashes)) {
                    $res = $i;
                    break;
                }
            }
            $prev = $hashes[$i];
        }
        return $res;
    }

    private
    function checkIfValid(int $point, array $hashes): bool
    {
        $res = true;
        $left = $point;
        $right = $point + 1;
        $max = count($hashes) - 1;
        $moreThenOnce = 0;
        $i = 0;
        while ($left >= 0 && $right <= $max) {
            $level = levenshtein($hashes[$left], $hashes[$right]);
            if ($level > 1 || $moreThenOnce > 1) {
                $res = false;
                break;
            } elseif ($level === 1) {
                $moreThenOnce++;
            }
            $i++;
            $left--;
            $right++;
        }
        if ($moreThenOnce !== 1) {
            $res = false;
        }


        return $res;
    }

    private function oldFindFoldRow(array $map): int
    {
        $rows = [];
        foreach ($map as $line) {
            $rows[] = md5($line);
        }
        return $this->oldFindFoldNumber($rows);
    }

    private function oldFindFoldNumber(array $hashes): int
    {
        $max = count($hashes) - 1;
        $res = -1;
        $prev = null;
        for ($i = 0; $i <= $max; $i++) {
            if ($prev === $hashes[$i]) {
                if ($this->oldCheckIfValid($i - 1, $hashes)) {
                    $res = $i;
                    break;
                }
            }
            $prev = $hashes[$i];
        }
        return $res;
    }

    private function oldCheckIfValid(int $point, array $hashes): bool
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
