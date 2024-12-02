<?php

namespace AdventOfCode\Year2023\Day16;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private array $visited = [];
    private array $energized = [];
    private array $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $this->map[] = str_split($item);
        }

        $starts = $this->getAllStarts();
        foreach ($starts as $start) {
            $this->visited = [];
            $this->energized = [];
            $go = [$start];
            do {
                $tmp = [];
                foreach ($go as $item) {
                    $tmp = array_merge($tmp, $this->move($item));
                }
                $go = $tmp;

            } while (!empty($go));

            $result = max($result, count($this->energized));
        }

        return $result;
    }

    private function getAllStarts()
    {
        $res = [];
        $maxX = count($this->map[0]);
        $maxY = count($this->map);
        for ($x = 0; $x < $maxX; $x++) {
            $res[] = [$x, 0, 'S'];
            $res[] = [$x, $maxY-1, 'N'];
        }
        for ($y = 0; $y < $maxY; $y++) {
            $res[] = [0, $y, 'E'];
            $res[] = [$maxX-1, $y, 'W'];
        }

        return $res;
    }

    private function move(array $point)
    {
        [$x, $y, $side] = $point;
        $key = $x . '-' . $y . '-' . $side;
        $res = [];
        $this->energized[$x . '-' . $y] = 1;
        if (isset($this->visited[$key])) {
            return $res;
        }
        $this->visited[$key] = 1;
        $char = $this->map[$y][$x] . $side;
        switch ($char) {
            case '-E':
            case '.E':
                $res[] = [$x + 1, $y, $side];
                break;
            case '|N':
            case '.N':
                $res[] = [$x, $y - 1, $side];
                break;
            case '|S':
            case '.S':
                $res[] = [$x, $y + 1, $side];
                break;
            case '-W':
            case '.W':
                $res[] = [$x - 1, $y, $side];
                break;
            case '|E':
            case '|W':
                $res[] = [$x, $y - 1, 'N'];
                $res[] = [$x, $y + 1, 'S'];
                break;
            case '-N':
            case '-S':
                $res[] = [$x - 1, $y, 'W'];
                $res[] = [$x + 1, $y, 'E'];
                break;
            case '\S':
            case '/N':
                $res[] = [$x + 1, $y, 'E'];
                break;
            case '\W':
            case '/E':
                $res[] = [$x, $y - 1, 'N'];
                break;
            case '\N':
            case '/S':
                $res[] = [$x - 1, $y, 'W'];
                break;
            case '\E':
            case '/W':
                $res[] = [$x, $y + 1, 'S'];
                break;
        }
        $tmp = [];
        foreach ($res as $item) {
            if (isset($this->map[$item[1]][$item[0]])) {
                $tmp[] = $item;
            }
        }

        return $tmp;
    }
}
