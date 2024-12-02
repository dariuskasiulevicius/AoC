<?php

namespace AdventOfCode\Year2023\Day04;

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
        $winCards = [];
        foreach ($inputData as $key => $item) {
            $result++;
            [$play, $cards] = explode(': ', $item);
            [$win, $my] = explode(' | ', $cards);
            $win = array_values(array_filter(explode(' ', $win)));
            $my = array_values(array_filter(explode(' ', $my)));
            $count = count(array_intersect($my, $win));
            if ($count > 0) {
                if (!isset($winCards[$key])) {
                    $winCards[$key] = 0;
                }
//                $win[$key]++;
                for ($i = 1; $i <= $count; $i++) {
                    $new = $key +$i;
                    if (!isset($winCards[$new])) {
                        $winCards[$new] = 0;
                    }
                    $winCards[$new] += $winCards[$key] + 1;
                }
            }
        }

        $result += array_sum($winCards);

        return $result;
    }
}
