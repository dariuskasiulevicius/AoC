<?php

namespace AdventOfCode\Year2023\Day10;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private array $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $y => $item) {
            $y--;
            foreach (str_split($item) as $x => $char) {
                $this->map[$y][$x] = $char;
                if ($char === 'S') {
                    $start = [$x, $y];
                }
            }
        }

        foreach (['N', 'E', 'S', 'W'] as $item) {
            $point = $start;
            $looking = $item;
            $step = 0;
            do {
                try {
                    [$point, $looking] = $this->move($point, $looking);
                } catch (\LogicException $e) {
                    echo $e->getMessage() . PHP_EOL;
                    continue 2;
                }
                $step++;

            } while (!$this->identical($start, $point));
            $result = $step / 2;
            break;
        }

        return $result;
    }

    private function identical($first, $second): bool
    {
        return $first[0] === $second[0] && $first[1] === $second[1];
    }

    private function move($point, $looking)
    {
        $char = $this->map[$point[1]][$point[0]] . $looking;
        switch ($char) {
            case '|N':
            case 'SN':
                $res = [$point[0], $point[1] - 1];
                $looking = 'N';
                break;
            case 'SE':
                $res = [$point[0] + 1, $point[1]];
                $looking = 'E';
                break;
            case 'SS':
                $res = [$point[0], $point[1] + 1];
                $looking = 'S';
                break;
            case 'SW':
                $res = [$point[0] - 1, $point[1]];
                $looking = 'W';
                break;
            case '|S':
                $res = [$point[0], $point[1] + 1];
                $looking = 'S';
                break;
            case '-E':
                $res = [$point[0] + 1, $point[1]];
                $looking = 'E';
                break;
            case '-W':
                $res = [$point[0] - 1, $point[1]];
                $looking = 'W';
                break;
            case 'LS':
                $res = [$point[0] + 1, $point[1]];
                $looking = 'E';
                break;
            case 'LW':
                $res = [$point[0], $point[1] - 1];
                $looking = 'N';
                break;
            case 'JS':
                $res = [$point[0] - 1, $point[1]];
                $looking = 'W';
                break;
            case 'JE':
                $res = [$point[0], $point[1] - 1];
                $looking = 'N';
                break;
            case '7E':
                $res = [$point[0], $point[1] + 1];
                $looking = 'S';
                break;
            case '7N':
                $res = [$point[0] - 1, $point[1]];
                $looking = 'W';
                break;
            case 'FN':
                $res = [$point[0] + 1, $point[1]];
                $looking = 'E';
                break;
            case 'FW':
                $res = [$point[0], $point[1] + 1];
                $looking = 'S';
                break;
            default:
                throw new \LogicException('Missing case ' . $char . ' ' . var_export($point, true));
        }

        return [$res, $looking];
    }
}
