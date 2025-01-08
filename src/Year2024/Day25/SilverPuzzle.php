<?php

namespace AdventOfCode\Year2024\Day25;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $keys = [];
        $locks = [];
        $isKey = false;
        $isNewLine = true;
        $thing = 0;
        foreach ($inputData as $item) {
            if ($item === '') {
                if ($isKey) {
                    $keys[] = $this->getInfo($thing);
                } else {
                    $locks[] = $this->getInfo($thing);
                }
                $thing = 0;
                $isNewLine = true;
                continue;
            }
            if ($isNewLine) {
                if ($item === '.....') {
                    $isKey = true;
                } else {
                    $isKey = false;
                }
                $isNewLine = false;
            }
            $thing += str_replace(['.', '#'], [0, 1], $item);
        }
        if ($isKey) {
            $keys[] = $this->getInfo($thing);
        } else {
            $locks[] = $this->getInfo($thing);
        }

        foreach ($keys as $key) {
            foreach ($locks as $lock) {
                $valid = true;
                for($i = 0; $i < 5; $i++) {
                    if ($key[$i] + $lock[$i] > 5) {
                        $valid = false;
                        break;
                    }
                }
                if($valid){
                    $result++;
                }
            }
        }

        return $result;
    }

    private function getInfo(int $thing): array
    {
        $thing = $thing - 11111;

        return str_split(str_pad((string) $thing, 5, '0', STR_PAD_LEFT));
    }
}
