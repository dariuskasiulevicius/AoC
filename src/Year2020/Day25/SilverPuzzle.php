<?php

namespace AdventOfCode\Year2020\Day25;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;

        $cardPublic = 14082811;
        $cardLoopSize = $this->findLoop($cardPublic);
        $doorPublic = 5249543;
        $doorLoopSize = $this->findLoop($doorPublic);

        $result = $this->loop($cardLoopSize, $doorPublic);
        if ($result !== $this->loop($doorLoopSize, $cardPublic)){
            throw new \Exception('Failed');
        }

        return $result;
    }

    public function loop($iter, $pubKey)
    {
        $result = 1;
        for ($i = 1; $i <= $iter; $i++) {
            $result *= $pubKey;
            $result %=20201227;
        }
        return $result;
    }

    public function findLoop($pubKey)
    {
        $val = 1;
        $i = 0;
        while ($val !== $pubKey) {
            $val *= 7;
            $val %= 20201227;
            $i++;
        }

        return $i;
    }
}
