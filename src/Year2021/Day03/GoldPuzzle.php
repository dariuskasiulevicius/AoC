<?php

namespace AdventOfCode\Year2021\Day03;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $elements = [];
        foreach ($inputData as $item) {
            $elements[] = array_map("intval", str_split($item));
        }

        $total = count($elements[0]);
        $most = $elements;
        for ($i = 0; $i< $total; $i++) {
            if(count($most) > 1) {
            $most = $this->mostBitsInPosition($most, $i);
            } else {
                break;
            }
        }

        $rating = bindec(implode("", $most[0]));
        echo $rating;

        $total = count($elements[0]);
        $less = $elements;
        for ($i = 0; $i< $total; $i++) {
            if(count($less) > 1) {
                $less = $this->lessBitsInPosition($less, $i);
            } else {
                break;
            }
        }

        $co = bindec(implode("", $less[0]));
        echo $co;


        return $co * $rating;
    }

    private function mostBitsInPosition(array $inputData, int $position): array
    {
        $counts = array_fill(0, count($inputData[0]), 0);
        $total = 0;
        foreach ($inputData as $item) {
            foreach ($item as $index => $val) {
                if ((int)$val === 1) {
                    $counts[$index]++;
                }
            }
            $total++;
        }


        $bit =(int) ($counts[$position] >= ($total / 2));

        $result = [];
        foreach ($inputData as $inputDatum) {
            if($inputDatum[$position] === $bit) {
                $result[] = $inputDatum;
            }
        }

        return $result;
    }

    private function lessBitsInPosition(array $inputData, int $position): array
    {
        $counts = array_fill(0, count($inputData[0]), 0);
        $total = 0;
        foreach ($inputData as $item) {
            foreach ($item as $index => $val) {
                if ((int)$val === 1) {
                    $counts[$index]++;
                }
            }
            $total++;
        }


        $bit =(int) ($counts[$position] < ($total / 2));

        $result = [];
        foreach ($inputData as $inputDatum) {
            if($inputDatum[$position] === $bit) {
                $result[] = $inputDatum;
            }
        }

        return $result;
    }
}
