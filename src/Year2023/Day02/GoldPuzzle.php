<?php

namespace AdventOfCode\Year2023\Day02;

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

        foreach ($games as $key => $game) {
            $max = ['red' => 0, 'green' => 0, 'blue' => 0];
            foreach ($game as $items) {
                foreach ($items as $color => $number) {
                    $max[$color] = max($max[$color], $number);
                }
            }
            $sum = 1;
            foreach ($max as $color => $left) {
                $sum *= $left;
            }
            $result += $sum;
        }

        return $result;
    }
}
