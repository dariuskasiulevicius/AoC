<?php

namespace AdventOfCode\Year2022\Day22;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

//(You guessed 66284.)That's not the right answer; your answer is too low. If you're stuck, make sure you're using the full input data; there are also some general tips on the about page, or you can ask for hints on the subreddit. Please wait one minute before trying again. (You guessed 66284.)
class SilverPuzzle implements PuzzleResolver
{
    private array $point = [];
    private string $facing = 'E';
    private array $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $empty = false;
        $actionLine = [];
        foreach ($inputData as $item) {
            if (empty($item)) {
                $empty = true;
                continue;
            }
            if (!$empty) {
                $item = $inputData->getFullLine();
                $line = str_split($item, 1);
                $this->map[] = array_filter($line, 'trim');
            } else {
                preg_match_all('/\d+[RL]?/', $item, $matches);
                foreach ($matches[0] as $match) {
                    if($match[strlen($match) - 1] === 'R' || $match[strlen($match) - 1] === 'L'){
                        $actionLine[] = (int)substr($match, 0, -1);
                        $actionLine[] = $match[strlen($match) - 1];
                    } else {
                        $actionLine[] = (int)$match;
                    }
                }
            }
        }

        $this->point = [array_key_first($this->map[0]), 0];

        foreach ($actionLine as $item) {
            if (is_int($item)) {
                $this->move($item);
            } else {
                $this->rotate($item);
            }
        }

        $faceSide = ['E' => 0, 'S' => 1, 'W' => 2, 'N' => 3];

        return 1000 * ($this->point[1]+1) + 4 * ($this->point[0]+1) + $faceSide[$this->facing];
    }

    private function move($steps)
    {
        switch ($this->facing) {
            case 'E':
                $offset = [1, 0];
                break;
            case 'W':
                $offset = [-1, 0];
                break;
            case 'N':
                $offset = [0, -1];
                break;
            case 'S':
                $offset = [0, 1];
                break;
        }
        for ($i = 0; $i < $steps; $i++) {
            $newPoint = [$this->point[0] + $offset[0], $this->point[1] + $offset[1]];
            $valid = $this->validMapPoint($newPoint);
            if ($valid === 'empty') {
                $this->point = $newPoint;
            } elseif ($valid === 'wall') {
                break;
            } elseif ($valid === 'space') {
                $jumpPoint = $this->jump($newPoint);
                if ($jumpPoint[0] === $newPoint[0] && $jumpPoint[1] === $newPoint[1]) {
                    break;
                }
                $this->point = $jumpPoint;
            }
        }
    }

    private function jump($point)
    {
        switch ($this->facing) {
            case 'E':
                $newPoint = [array_key_first($this->map[$point[1]]), $point[1]];
                break;
            case 'W':
                $newPoint = [array_key_last($this->map[$point[1]]), $point[1]];
                break;
            case 'N':
                for ($yy = array_key_last($this->map); $yy > 0; $yy--) {
                    if (isset($this->map[$yy][$point[0]])) {
                        $newPoint = [$point[0], $yy];
                        break;
                    }
                }
                break;
            case 'S':
                $last = array_key_last($this->map);
                for ($yy = 0; $yy <= $last; $yy++) {
                    if (isset($this->map[$yy][$point[0]])) {
                        $newPoint = [$point[0], $yy];
                        break;
                    }
                }
                break;
        }

        $valid = $this->validMapPoint($newPoint);
        if ($valid === 'wall') {
            return $point;
        }
        if ($valid === 'empty') {
            return $newPoint;
        }
        if ($valid === 'space') {
            throw new \Exception('Imposible');
        }
    }

    private function validMapPoint($point)
    {
        if (isset($this->map[$point[1]][$point[0]])) {
            if ($this->map[$point[1]][$point[0]] === '#') {
                return 'wall';
            }
            return 'empty';
        }

        return 'space';
    }

    private function rotate($side)
    {
        $rotateMap = [
            'L' => ['E' => 'N', 'N' => 'W', 'W' => 'S', 'S' => 'E'],
            'R' => ['E' => 'S', 'S' => 'W', 'W' => 'N', 'N' => 'E'],
        ];
        $this->facing = $rotateMap[$side][$this->facing];
    }
}
