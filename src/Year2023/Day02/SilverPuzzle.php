<?php

namespace AdventOfCode\Year2023\Day02;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;
use Symfony\Contracts\Service\Test\ServiceLocatorTest;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $games = [];
        foreach ($inputData as $item) {
            [$game, $set] = explode(':', $item);
            $game = str_replace('Game ', '', $game);
            $sets = explode(';', $set);
            foreach ($sets as $cards) {
                $card = explode(',', $cards);
                $hand = [];
                foreach ($card as $colors) {
                    [$number, $color] = explode(' ', trim($colors));
                    $hand[$color] = $number;
                }
                $games[$game][] = $hand;
            }
        }

        $limits = ['red' => 12, 'green' => 13, 'blue' => 14];
        foreach ($games as $key => $game) {
//            $many = $limits;
            $invalid = false;
            foreach ($game as $items) {
                foreach ($items as $color => $number) {
                    if ($limits[$color] < $number) {
                        $invalid = true;
                        break 2;
                    }
//                    $many[$color] -= $number;
                }
            }
//            foreach ($many as $color => $left) {
//                if ($left < 0) {
//                    $invalid = true;
//                }
//            }
            if (!$invalid) {
                $result += $key;
            }
        }


        return $result;
    }
}
