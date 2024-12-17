<?php

namespace AdventOfCode\Year2024\Day14;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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
        $xMiddle = ($size[0] - 1) / 2;
        $yMiddle = ($size[1] - 1) / 2;

        $result = 0;
        do {
            $robots = $this->stepRobots($robots, $size);
            $result++;
            $simmetric = $this->isSimmetric($robots, $xMiddle, $yMiddle);
            if($result % 10000 === 0) {
                echo $result . PHP_EOL;
            }
            if (in_array($result, [86, 189, 292])) {
                $simmetric = false;
            }
        } while (!$simmetric);
        $this->printMap($robots, $size);

        return $result;
    }

    private function stepRobots(array $robots, array $size): array
    {
        foreach ($robots as $key => $robot) {
            $k = ($robot[0] + $robot[2]) % $size[0];
            if ($k < 0) {
                $k += $size[0];
            }
            $i = ($robot[1] + $robot[3]) % $size[1];
            if ($i < 0) {
                $i += $size[1];
            }
            $robots[$key] = [$k, $i, $robot[2], $robot[3]];
        }

        return $robots;
    }

    private function isSimmetric(array $robots, int $xMiddle, int $yMiddle): bool
    {
        $splited = [];
        $center = [];
        foreach ($robots as $item) {
            $splited[$item[1]] = ($splited[$item[1]] ?? 0) + 1;
            $center[$item[1]][$item[0]] = true;
        }
        $result = false;
        foreach ($splited as $key => $item) {
            if($item >= 33) {
                $line = '';
                for ($x= 0; $x < 101; $x++) {
                    $line .= isset($center[$key][$x]) ? 'X' : '.';
                }
                if(strpos($line, 'XXXXXXXXX') !== false) {
                    return true;
                }
            }
        }

        return $result;
    }

    private function printMap(array $map, array $size)
    {
        foreach ($map as $item) {
            $map[$item[0] . ';' . $item[1]] = ($map[$item[0] . ';' . $item[1]] ?? 0) + 1;
        }
        for ($i = 0; $i < $size[1]; $i++) {
            for ($k = 0; $k < $size[0]; $k++) {
                echo $map[$k . ';' . $i] ?? '.';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
