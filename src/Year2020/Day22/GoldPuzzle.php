<?php

namespace AdventOfCode\Year2020\Day22;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    protected $games = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $players = [];
        $deck = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if (!empty($item)) {
                $deck[] = $item;
            } else {
                $model = new Model();
                $model->assign($deck);
                $players[] = $model;
                $deck = [];
            }
        }
        if (!empty($deck)) {
            $model = new Model();
            $model->assign($deck);
            $players[] = $model;
        }

        $deck1 = $players[0]->getDeck();
        $deck2 = $players[1]->getDeck();

        $mem1 = implode(',', $deck1);
        $mem2 = implode(',', $deck2);
        $newGames = $mem1 . ';' . $mem2;

        list($winner, $deck) = $this->game($deck1, $deck2);
        $max = count($deck);
        echo implode(',', $deck) . PHP_EOL;

//        if (count($deck1) > 0) {
//            $max = count($deck1);
//            $deck = $deck1;
//        } else {
//            $max = count($deck2);
//            $deck = $deck2;
//        }
        foreach ($deck as $item) {
            $result += $item * $max;
            $max--;
        }

        return $result;
    }

    protected function game($deck1, $deck2)
    {
        $mem1 = implode(',', $deck1);
        $mem2 = implode(',', $deck2);
        $newGames = $mem1 . ';' . $mem2;
        if (isset($this->games[$newGames])) {
//            echo 'found' . PHP_EOL;
            return $this->games[$newGames];
        }
        $iteration = 0;
        $games = [];
        do {
            $start1 = implode(',', $deck1);
            $start2 = implode(',', $deck2);
            if (isset($games[$start1]) || isset($games[$start2])) {
                return [1, null];
            }
            $games[$start1] = true;
            $games[$start2] = true;
            $card1 = array_shift($deck1);
            $card2 = array_shift($deck2);
            if (count($deck1) >= $card1 && count($deck2) >= $card2) {
                list($winner) = $this->game(array_slice($deck1, 0, $card1), array_slice($deck2, 0, $card2));
            } elseif ($card1 > $card2) {
                $winner = 1;
            } else {
                $winner = 2;
            }

            if ($winner === 1) {
                $deck1[] = $card1;
                $deck1[] = $card2;
            } elseif ($winner === 2) {
                $deck2[] = $card2;
                $deck2[] = $card1;
            }
            $iteration++;
//            echo $iteration . PHP_EOL;
        } while (!(empty($deck1) || empty($deck2)));
        if (!empty($deck1)) {
            $winner = 1;
            $deck = $deck1;
        } else {
            $winner = 2;
            $deck = $deck2;
        }

        $this->games[$newGames] = [$winner, $deck];
//        echo $newGames . PHP_EOL;
//        echo 'size ' . count($this->games) . PHP_EOL;

        return [$winner, $deck];
    }
}
