<?php

namespace AdventOfCode\Year2024\Day14;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $robots = [];
        foreach ($inputData as $item) {
            [$pos, $vel] = explode(' ', str_replace(['p=', 'v=',], '', $item));
            $pos = explode(',', $pos);
            $vel = explode(',', $vel);
            $robots[] = [$pos[0], $pos[1], $vel[0], $vel[1]];
        }

        $size = [101, 103];
        $step = 100;
        $after = [];
        $map = [];
        foreach ($robots as $robot) {
            $k = ($robot[0] + $robot[2] * $step) % $size[0];
            if ($k < 0) {
                $k += $size[0];
            }
            $i = ($robot[1] + $robot[3] * $step) % $size[1];
            if ($i < 0) {
                $i += $size[1];
            }
            $after[] = [$k, $i];
            $map[$k . ';' . $i] = ($map[$k . ';' . $i] ?? 0) + 1;
        }

        $this->printMap($map, $size);
        $x = ($size[0] - 1) / 2 ;
        $y = ($size[1] - 1) / 2;

        $splited = [];
        foreach ($after as $item) {
            if($item[0] !== $x && $item[1] !== $y) {
                $ii = $item[0] < $x ? '0' : '1';
                $jj = $item[1] < $y ? '0' : '1';
                $splited[$ii . ';' . $jj] = ($splited[$ii . ';' . $jj] ?? 0) + 1;
            }
        }
        $result = 1;
        foreach ($splited as $item) {
            $result *= $item;
        }

        return $result;
    }

    private function printMap(array $map, array $size)
    {
        for ($i = 0; $i < $size[1]; $i++) {
            for ($k = 0; $k < $size[0]; $k++) {
                echo $map[$k . ';' . $i] ?? '.';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
