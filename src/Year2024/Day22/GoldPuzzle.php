<?php

namespace AdventOfCode\Year2024\Day22;

ini_set('memory_limit', '200G');

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
        $initialNumbers = [];
        foreach ($inputData as $item) {
            $initialNumbers[] = (int)$item;
        }

        $sequences = [];
        foreach ($initialNumbers as $initialNumber) {
            $sequence = [$initialNumber % 10];
            $num = $initialNumber;
            for ($i = 0; $i < 2000; $i++) {
                $num = $this->getNextNumber($num);
                $sequence[] = $num % 10;
            }
            $sequences[$initialNumber] = $sequence;
        }

        $diffs = [];
        foreach ($sequences as $key => $sequence) {
            $diff = [];
            $prev = null;
            foreach ($sequence as $item) {
                if ($prev === null) {
                    $prev = $item;
                    continue;
                }
                $diff[] = $item - $prev;
                $prev = $item;
            }
            $diffs[$key] = $diff;
        }
        $identicalSubsequence = $this->findIdenticalSubsequenceInDiffs($diffs, $sequences);

        foreach ($identicalSubsequence as $item) {
            $result = max($item, $result);
        }

        return $result;
    }

    private function getNextNumber(int $num): int
    {
        $num = ($num ^ ($num * 64)) % 16777216;
        $num = ($num ^ floor($num / 32)) % 16777216;
        $num = ($num ^ ($num * 2048)) % 16777216;

        return $num;
    }

    private function findIdenticalSubsequenceInDiffs(array $diffs, array $orgSeq): ?array
    {
        $sequences = [];
        foreach ($diffs as $key => $diff) {
            $seq = [];
            for ($i = 0; $i < count($diff) - 3; $i++) {
                $sequence = array_slice($diff, $i, 4);
                $k = implode(';', $sequence);
                if (!isset($seq[$k])) {
                    $seq[$k] = $orgSeq[$key][$i + 4];
                }
            }
            foreach ($seq as $k => $value) {
                if (isset($sequences[$k])) {
                    $sequences[$k] += $value;
                } else {
                    $sequences[$k] = $value;
                }
            }
        }

        return $sequences;
    }
}
