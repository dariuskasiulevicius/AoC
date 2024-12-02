<?php

namespace AdventOfCode\Year2023\Day07;

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
        $hands = [];
        foreach ($inputData as $item) {
            [$hand, $bid] = explode(' ', $item);
            $hands[] = [$hand, (int)$bid];
        }

        usort($hands, [$this, 'sortHands']);

        foreach ($hands as $rank => $hand) {
            $result += ($rank+1) * $hand[1];
        }


        return $result;
    }

    public function sortHands($left, $right)
    {
        $fLeft = count_chars($left[0], 1);
        $fRight = count_chars($right[0], 1);
        arsort($fLeft);
        arsort($fRight);

        $leftScore = $this->getScore(array_values($fLeft));
        $rightScore = $this->getScore(array_values($fRight));
        if ($leftScore < $rightScore) {
            return 1;
        }
        if ($leftScore > $rightScore) {
            return -1;
        }

        $score = [
            'A' => 14,
            'K' => 13,
            'Q' => 12,
            'J' => 11,
            'T' => 10,
            '9' => 9,
            '8' => 8,
            '7' => 7,
            '6' => 6,
            '5' => 5,
            '4' => 4,
            '3' => 3,
            '2' => 2,
        ];

        for ($i = 0; $i < 5; $i++) {
            if ($score[$left[0][$i]] > $score[$right[0][$i]]) {
                return 1;
            }
            if ($score[$left[0][$i]] < $score[$right[0][$i]]) {
                return -1;
            }
        }

        return 0;
    }

    protected function getScore($numbers)
    {
        if ($numbers[0] === 5) {
            return 0;
        }
        if ($numbers[0] === 4) {
            return 1;
        }
        if ($numbers[0] === 3 && $numbers[1] === 2) {
            return 2;
        }
        if ($numbers[0] === 3) {
            return 3;
        }
        if ($numbers[0] === 2 && $numbers[1] === 2) {
            return 4;
        }
        if ($numbers[0] === 2) {
            return 5;
        }

        return 6;
    }
}
