<?php

namespace AdventOfCode\Year2020\Day04;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result =0;
        $pass = null;
        foreach ($inputData as $item) {
            if (empty($item)) {
                if ($pass->isGoldValid()) {
                    $result ++;
                }
                $pass = null;
            } else {
                if (null === $pass) {
                    $pass = new Model();
                }
                $pass->assign($item);
            }
        }
        if ($pass->isGoldValid()) {
            $result ++;
        }

        return $result;
    }
}
