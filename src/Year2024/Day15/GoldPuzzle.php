<?php

namespace AdventOfCode\Year2024\Day15;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $next = false;
        $map = [];
        $pos = [];
        $actions = '';
        foreach ($inputData as $key => $itemSmall) {
            $item = str_replace(['#', 'O', '.', '@'], ['##', '[]', '..', '@.'], $itemSmall);
            $y = $key - 1;
            if (empty($item)) {
                $next = true;
            } elseif ($next) {
                $actions .= $item;
            } else {
                foreach (str_split($item) as $x => $char) {
                    if ($char === '@') {
                        $pos = [$x, $y];
                    } elseif ($char !== '.') {
                        $map[$this->getKey($x, $y)] = $char;
                    }
                }
            }
        }
        $this->printMap($map, $pos);
        $steps = ['v' => [0, 1], '>' => [1, 0], '^' => [0, -1], '<' => [-1, 0]];
//348 atrodo OK
        $print = false;
        foreach (str_split($actions) as $key => $step) {
            if ($print) {
                echo $key . ' ' . $step . PHP_EOL;
            }
            [$xEmpty, $yEmpty] = $this->getEmptyCell($map, $pos, $steps[$step], $step);
            if ($xEmpty !== 0 && $yEmpty !== 0) {
                $pos[0] += $steps[$step][0];
                $pos[1] += $steps[$step][1];
                if ($step === '<') {
                    for ($i = $xEmpty; $i < $pos[0]; $i++) {
                        $key = $this->getKey($i + 1, $pos[1]);
                        if (isset($map[$key])) {
                            $map[$this->getKey($i, $pos[1])] = $map[$key];
                            unset($map[$key]);
                        }
                    }
                } elseif ($step === '>') {
                    for ($i = $xEmpty; $i > $pos[0]; $i--) {
                        $key = $this->getKey($i - 1, $pos[1]);
                        if (isset($map[$key])) {
                            $map[$this->getKey($i, $pos[1])] = $map[$key];
                            unset($map[$key]);
                        }
                    }
                } elseif ($step === '^' || $step === 'v') {
                    $boxes = $this->getBoxes($map, $pos, $steps[$step]);
                    $newBoxes = [];
                    foreach ($boxes as $box) {
                        $key = $this->getKey($box[0], $box[1]);
                        if (isset($map[$key])) {
                            $newBoxes[$this->getKey($box[0] + $steps[$step][0], $box[1] + $steps[$step][1])] = $map[$key];
                            unset($map[$key]);
                        }
                    }
                    $map = array_merge($map, $newBoxes);
                }
            }
            if ($print) {
                $this->printMap($map, $pos);
            }
        }
        echo $key . PHP_EOL;
        $this->printMap($map, $pos);

        foreach ($map as $key => $item) {
            if ($item === '[') {
                [$x, $y] = $this->splitKey($key);
                $result += 100 * $y + $x;
            }
        }

        //1479117 your answer is too low
        return $result;
    }

    private function getBoxes(array $map, array $pos, array $step): array
    {
        $boxes = [];
        if (isset($map[$this->getKey($pos[0], $pos[1])])) {
            $boxes[] = $pos;
        }
        if (isset($map[$this->getKey($pos[0], $pos[1])]) && $map[$this->getKey($pos[0], $pos[1])] === '[') {
            $boxes[] = [$pos[0] + 1, $pos[1]];
        } elseif (isset($map[$this->getKey($pos[0], $pos[1])]) && $map[$this->getKey($pos[0], $pos[1])] === ']') {
            $boxes[] = [$pos[0] - 1, $pos[1]];
        }
        $newBoxes = $boxes;
        while (count($newBoxes) > 0) {
            $kBoxes = [];
            foreach ($newBoxes as $newBox) {
                $key = $this->getKey($newBox[0] + $step[0], $newBox[1] + $step[1]);
                if (isset($map[$key]) && $map[$key] === '[') {
                    $kBoxes[] = [$newBox[0] + $step[0], $newBox[1] + $step[1]];
                    $boxes[] = [$newBox[0] + $step[0], $newBox[1] + $step[1]];
                    $kBoxes[] = [$newBox[0] + $step[0] + 1, $newBox[1] + $step[1]];
                    $boxes[] = [$newBox[0] + $step[0] + 1, $newBox[1] + $step[1]];
                } elseif (isset($map[$key]) && $map[$key] === ']') {
                    $kBoxes[] = [$newBox[0] + $step[0], $newBox[1] + $step[1]];
                    $boxes[] = [$newBox[0] + $step[0], $newBox[1] + $step[1]];
                    $kBoxes[] = [$newBox[0] + $step[0] - 1, $newBox[1] + $step[1]];
                    $boxes[] = [$newBox[0] + $step[0] - 1, $newBox[1] + $step[1]];
                }
            }
            $newBoxes = $kBoxes;
        }

        return $boxes;
    }

    private
    function getEmptyCell(array $map, array $pos, array $step, string $arrow): array
    {
        $continue = true;
        $x = $pos[0];
        $y = $pos[1];
        $boxes = [[$x, $y]];
        do {
//            $prev = $map[$this->getKey($x, $y)] ?? '';
            $x += $step[0];
            $y += $step[1];
            $key = $this->getKey($x, $y);
            if ($arrow === 'v' || $arrow === '^') {
                if ($this->canPush($map, $boxes, $step) === false) {
                    return [0, 0];
                }
                if ($this->isEmpty($map, $boxes, $step)) {
                    $continue = false;
                } else {
                    $newBoxes = [];
                    foreach ($boxes as $box) {
                        $ix = $box[0] + $step[0];
                        $iy = $box[1] + $step[1];
                        if (isset($map[$this->getKey($ix, $iy)]) && $map[$this->getKey($ix, $iy)] === '[') {
                            $newBoxes[$this->getKey($ix, $iy)] = [$ix, $iy];
                            $newBoxes[$this->getKey($ix + 1, $iy)] = [$ix + 1, $iy];
                        } elseif (isset($map[$this->getKey($ix, $iy)]) && $map[$this->getKey($ix, $iy)] === ']') {
                            $newBoxes[$this->getKey($ix, $iy)] = [$ix, $iy];
                            $newBoxes[$this->getKey($ix - 1, $iy)] = [$ix - 1, $iy];
                        }
                    }
                    $boxes = array_values($newBoxes);
                    $continue = true;
                }
            } elseif (isset($map[$key]) && $map[$key] === '#') {
                return [0, 0];
            } elseif (($arrow === '<' || $arrow === '>') && !isset($map[$key])) {
                $continue = false;
            }
        } while ($continue);

        return [$x, $y];
    }

    private
    function canPush(array $map, array $boxes, array $step): bool
    {
        foreach ($boxes as $box) {
            $key = $this->getKey($box[0] + $step[0], $box[1] + $step[1]);
            if (isset($map[$key]) && $map[$key] === '#') {
                return false;
            }
        }
        return true;
    }

    private
    function isEmpty(array $map, array $boxes, array $step): bool
    {
        foreach ($boxes as $box) {
            $key = $this->getKey($box[0] + $step[0], $box[1] + $step[1]);
            if (isset($map[$key])) {
                return false;
            }
        }

        return true;
    }

    private
    function getKey(int $x, int $y)
    {
        return $x . ';' . $y;
    }

    private
    function splitKey(string $key): array
    {
        return explode(';', $key);
    }

    private
    function printMap(array $map, array $pos): void
    {
        $minX = 0;
        $maxX = 0;
        $minY = 0;
        $maxY = 0;
        foreach ($map as $key => $item) {
            [$x, $y] = $this->splitKey($key);
            $minX = min($minX, $x);
            $maxX = max($maxX, $x);
            $minY = min($minY, $y);
            $maxY = max($maxY, $y);
        }
        for ($y = $minY; $y <= $maxY; $y++) {
            for ($x = $minX; $x <= $maxX; $x++) {
                if ($pos[0] === $x && $pos[1] === $y) {
                    echo '@';
                } else {
                    echo $map[$this->getKey($x, $y)] ?? '.';
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
