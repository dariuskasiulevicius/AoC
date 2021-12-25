<?php

namespace AdventOfCode\Year2021\Day21;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private $knowSituations = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = $this->play(8, 4, 0, 0);


        var_export($result);

        return max($result);
    }

    private function play($aPosition, $bPosition, $aScore, $bScore)
    {
        $key = json_encode([$aPosition, $bPosition, $aScore, $bScore]);
        $win = $this->knowSituations[$key] ?? false;
        if ($win !== false) {
            return $win;
        }
        $win = [0, 0];

        foreach ([[3, 1], [4, 3], [5, 6], [6, 7], [7, 6], [8, 3], [9, 1]] as $roll) {
            $newPosition = $aPosition + $roll[0];
            if ($newPosition > 10) {
                $newPosition -= 10;
            }
            $newScore = $aScore + $newPosition;
            if ($newScore >= 21) {
                $win[0] += $roll[1];
                continue;
            }
            $ow = $this->play($bPosition, $newPosition, $bScore, $newScore);
            $win[1] += $ow[0] * $roll[1];
            $win[0] += $ow[1] * $roll[1];
        }
        $this->knowSituations[$key] = $win;

        return $win;
    }
}
