<?php

namespace AdventOfCode\Year2022\Day24;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private $mapCache = [];
    private $mapN = [];
    private $mapS = [];
    private $mapW = [];
    private $mapE = [];
    private $mapWalls = [];
    private $visited = [];
    private int $mx = 0;
    private int $my = 0;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $map[] = str_split($item, 1);
        }
        $this->mx = array_key_last($map[0]);
        $this->my = array_key_last($map);
        foreach (end($map) as $key => $item) {
            if ($item === '.') {
                $finish = [$key, $this->my];
            }
        }
        $this->mapCache[0] = $map;
        foreach ($map as $y => $line) {
            foreach ($line as $x => $value) {
                switch ($value) {
                    case '^':
                        $this->mapN[$y][$x] = '^';
                        break;
                    case 'v':
                        $this->mapS[$y][$x] = 'v';
                        break;
                    case '<':
                        $this->mapW[$y][$x] = '<';
                        break;
                    case '>':
                        $this->mapE[$y][$x] = '>';
                        break;
                    case '#':
                        $this->mapWalls[$y][$x] = '#';
                        break;
                }
            }
        }

        return $this->move($finish);
    }

    private function move($finish)
    {
        $result = 0;
        $cycle = 0;
//        $this->printMaps();
        $path = [[1, 0], $finish, [1, 0], $finish];
        $iiMax = count($path);
        for ($ii = 1; $ii < $iiMax; $ii++) {
            $start = $path[$ii - 1];
            $finish = $path[$ii];

            $visit = [];
            $key = $this->getKey($start[0], $start[1], $result, $finish);
            $visit[$key] = [$start[0], $start[1], 0, $result];
            $binThere = [];
            $binThere[$key] = $result;
            $t = $result;
            while (!empty($visit)) {
                $bestNumber = $this->getBest($visit, $finish);
                [$x, $y, $visited, $t] = $visit[$bestNumber];
                if ($cycle % 10000 === 0) {
                    echo 'c ' . $cycle . ' ' . count($visit) . ' r ' . $result . ' t ' . $t . PHP_EOL;
                }
                unset($visit[$bestNumber]);

                if ($x === $finish[0] && $y === $finish[1]) {
                    $result = $t;
                    break;
                }

                $t++;
                $map = $this->getMap($t);
                $next = $this->getNext([$x, $y], $map);

                foreach ($next as $item) {
                    [$xx, $yy] = $item;
                    $key = $this->getKey($xx, $yy, $t, $finish);
                    if (!isset($binThere[$key])) {
                        $binThere[$key] = PHP_INT_MAX;
                    }

                    if ($t <= $binThere[$key]) {
                        $binThere[$key] = $t;
                        $vv = 0;
                        $visit[$key] = [$xx, $yy, $vv, $t];
                    }
                }
                $cycle++;
            }
            echo 'Cycle ' . $cycle . ' r ' . $result . PHP_EOL;
        }

        return $result;
    }


    private function getKey($x, $y, $t, $finish)
    {
        $distance = abs($x - $finish[0]) + abs($y - $finish[1]);

        return implode(';', [$distance + $t, $x, $y, $t]);
    }

    private function getShortKey($x, $y)
    {
        return $x . ';' . $y;
    }

    private function getBest($items, $finish)
    {
        $best = 0;
        $bestValue = PHP_INT_MAX;
        foreach ($items as $key => $item) {
            $length = abs($item[0] - $finish[0]) + abs($item[1] - $finish[1]) + $item[3];
            if ($length < $bestValue) {
                $bestValue = $length;
                $best = $key;
            }
        }

        return $best;
    }

    private function getMap($time)
    {
        if (!isset($this->mapCache[$time])) {
            $last = array_key_last($this->mapCache);
            for ($i = $last; $i < $time; $i++) {
                $this->mapN = $this->modifyMaps($this->mapN, [0, -1], [0, $this->my - 1]);
                $this->mapS = $this->modifyMaps($this->mapS, [0, 1], [0, 1]);
                $this->mapW = $this->modifyMaps($this->mapW, [-1, 0], [$this->mx - 1, 0]);
                $this->mapE = $this->modifyMaps($this->mapE, [1, 0], [1, 0]);
                $newMap = [];
                for ($y = 0; $y <= $this->my; $y++) {
                    for ($x = 0; $x <= $this->mx; $x++) {
                        if ($this->hasWall([$x, $y])) {
                            $newMap[$y][$x] = '#';
                        } elseif ($this->hasObj([$x, $y])) {
                            $newMap[$y][$x] = '*';
                        }
                    }
                }
                $this->mapCache[$i + 1] = $newMap;
            }

        }

        return $this->mapCache[$time];
    }

    private function getNext($pos, $map)
    {
        [$x, $y] = $pos;
        $move = [[0, 1], [1, 0], [0, -1], [-1, 0], [0, 0]];
        $next = [];
        foreach ($move as $item) {
            $xx = $x + $item[0];
            $yy = $y + $item[1];
            if (
                $xx >= 0 && $xx <= $this->mx
                && $yy >= 0 && $yy <= $this->my
                && !isset($map[$yy][$xx])
            ) {
                $next[] = [$xx, $yy];
            }
        }

        return $next;
    }

    private function modifyMaps($map, $offset, $jump)
    {
        $newMap = [];
        foreach ($map as $y => $line) {
            foreach ($line as $x => $val) {
                $xx = $x + $offset[0];
                $yy = $y + $offset[1];
                if ($this->hasWall([$xx, $yy])) {
                    if ($jump[0] !== 0) {
                        $xx = $jump[0];
                    }
                    if ($jump[1] !== 0) {
                        $yy = $jump[1];
                    }
                }
                $newMap[$yy][$xx] = $val;
            }
        }

        return $newMap;
    }

    private function hasWall($pos)
    {
        return isset($this->mapWalls[$pos[1]][$pos[0]])
            || $pos[0] < 0 || $pos[0] > $this->mx
            || $pos[1] < 0 || $pos[1] > $this->my;
    }

    private function hasObj($pos)
    {
        [$x, $y] = $pos;
        return
            isset($this->mapN[$y][$x])
            || isset($this->mapS[$y][$x])
            || isset($this->mapW[$y][$x])
            || isset($this->mapE[$y][$x]);
    }

    private function printMaps()
    {
        for ($y = 0; $y <= $this->my; $y++) {
            for ($x = 0; $x <= $this->mx; $x++) {
                if ($this->hasWall([$x, $y])) {
                    echo '#';
                } elseif ($this->hasObj([$x, $y])) {
                    echo $this->mapN[$y][$x] ?? $this->mapW[$y][$x] ?? $this->mapS[$y][$x] ?? $this->mapE[$y][$x];
                } else {
                    echo '.';
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    private function printVisited($visited)
    {
        for ($y = 0; $y <= $this->my; $y++) {
            for ($x = 0; $x <= $this->mx; $x++) {
                echo $visited[$y][$x] ?? '.';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
