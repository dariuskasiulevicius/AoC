<?php

namespace AdventOfCode\Year2021\Day20;

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
        $mask = null;
        $image = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if ($mask === null) {
                $mask = $this->transformToNumbers($item);
            } elseif (!empty($item)) {
                $image[] = $this->transformToNumbers($item);
            }
        }

        for ($i = 0; $i < 50; $i++) {
            $image = $this->increaseImage($image, $i%2);
            $image = $this->encodeImage($image, $mask);
//            $this->print($image);
        }
        $result = $this->sum($image);


        return $result;
    }

    private function transformToNumbers($line)
    {
        $line = str_replace(['.', '#'], ['0', '1'], $line);

        return array_map('intval', str_split($line));
    }

    private function increaseImage($image, $fill)
    {
        $max = count($image);
        $newMax = $max + 6;
        $newImage = [];
        $emptyLine = array_fill(0, $newMax, $fill);
        for ($i = 0; $i < 3; $i++) {
            $newImage[] = $emptyLine;
        }
        foreach ($image as $row) {
            $newImage[] = array_merge([$fill, $fill, $fill], $row, [$fill, $fill, $fill]);
        }
        for ($i = 0; $i < 3; $i++) {
            $newImage[] = $emptyLine;
        }

        return $newImage;
    }

    private function encodeImage($image, $mask)
    {
        $newImage = [];
        $max = count($image) - 2;
        for ($y = 0; $y < $max; $y++) {
            for ($x = 0; $x < $max; $x++) {
                $code = $image[$y][$x] . $image[$y][$x + 1] . $image[$y][$x + 2]
                    . $image[$y + 1][$x] . $image[$y + 1][$x + 1] . $image[$y + 1][$x + 2]
                    . $image[$y + 2][$x] . $image[$y + 2][$x + 1] . $image[$y + 2][$x + 2];
                $code = bindec($code);
                $newImage[$y][$x] = $mask[$code];
            }
        }

        return $newImage;
    }

    private function print($image)
    {
        foreach ($image as $item) {
            echo str_replace(['0', '1'], ['.', '#'], implode('', $item)) . PHP_EOL;
        }
        echo PHP_EOL;
    }

    private function sum($image)
    {
        $sum = 0;
        foreach ($image as $item) {
            $sum += array_sum($item);
        }

        return $sum;
    }
}
