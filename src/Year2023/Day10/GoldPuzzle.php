<?php

namespace AdventOfCode\Year2023\Day10;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private array $map = [];
    private array $poligonMap = [];

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
                $this->poligonMap[$y][$x] = '.';
                if ($char === 'S') {
                    $start = [$x, $y];
                }
            }
        }

        foreach (['N', 'E', 'S', 'W'] as $item) {
            $point = $start;
            $resultMap = $this->poligonMap;
            $looking = $item;
            do {
                try {
                    [$point, $looking] = $this->move($point, $looking);
                } catch (\LogicException $e) {
                    echo $e->getMessage() . PHP_EOL;
                    continue 2;
                }
                if (isset($this->map[$point[1]][$point[0]])) {
                    $resultMap[$point[1]][$point[0]] = $this->map[$point[1]][$point[0]];
                }

            } while (!$this->identical($start, $point));
            break;
        }

        $this->printMap($resultMap);
        foreach ($resultMap as $y => $line) {
            foreach ($line as $x => $char) {
                if ($char === '.') {
                    if ($this->isInside($resultMap, $x, $y)) {
                        echo $x . ' ' . $y . PHP_EOL;
                        $result++;
                    }
                }
            }
        }

        return $result;
    }

    private function isInside($map, $x, $y): bool
    {
        $changes = 0;
        $corners = [];
        $side = ['L' => 'N', 'J' => 'N', '7' => 'S', 'F' => 'S', 'S' => 'N'];
        for ($i = $x; $i >= 0; $i--) {
            if (
                $map[$y][$i] === 'L'
                || $map[$y][$i] === 'J'
                || $map[$y][$i] === '7'
                || $map[$y][$i] === 'F'
                || $map[$y][$i] === 'S'
            ) {
                $corners[] = $side[$map[$y][$i]];
            } elseif ($map[$y][$i] === '|') {
                $changes++;
            }
        }
        $prev = null;
        foreach ($corners as $item) {
            if ($prev === null) {
                $prev = $item;
            } elseif ($prev !== $item) {
                $changes++;
                $prev = null;
            } else {
                $prev = null;
            }
        }

        return $changes % 2 !== 0;
    }

    private function identical($first, $second): bool
    {
        return $first[0] === $second[0] && $first[1] === $second[1];
    }

    private function move($point, $looking)
    {
        if (!isset($this->map[$point[1]][$point[0]])) {
            throw new \LogicException('Missing point ' . var_export($point, true));
        }
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

    private function printMap(array $map): void
    {
        foreach ($map as $item) {
            foreach ($item as $char) {
                echo $char;
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
