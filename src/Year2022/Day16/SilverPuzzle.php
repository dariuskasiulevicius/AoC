<?php

namespace AdventOfCode\Year2022\Day16;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $relations = [];
        $pressure = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if (false !== preg_match('/ ([A-Z]{2}) .*rate=(\d+); [ a-z]+ ([, A-Z]+)/', $item, $matches)) {
                $name = $matches[1];
                $value = (int)$matches[2];
                $pressure[$name] = $value;
                $relations[$name] = array_map('trim', explode(',', $matches[3]));
            } else {
                throw new \Exception('Unexpected error 16');
            }
        }

        return $this->move('AA', $pressure, $relations);
    }

    private function move($start, $pressure, $graph)
    {
        // node; releasing; released;
        $visiting = [[$start, 0, 0, $pressure, []]];
        for ($t = 0; $t < 30; $t++) {
            $newVisiting = [];
            $max = [];
            foreach ($visiting as $cur) {
                $cur[2] += $cur[1];
                $nexts = $this->getNext($cur[0], $graph, $cur[3]);
                foreach ($nexts as $next) {
                    if ($next === $cur[0]) {
                        $xx = $cur;
                        $xx[1] += $cur[3][$next];
                        $xx[0] = $next;
                        $xx[3][$next] = 0;
                        $xx[4][] = $cur[0];
                        $newVisiting[] = $xx;
                    } else {
                        $xx = $cur;
                        $xx[0] = $next;
                        $xx[4][] = $cur[0];
                        $newVisiting[] = $xx;
                    }
                    $max[$xx[2]] = true;
                }
            }
            $max = array_keys($max);
            rsort($max);
            $max = array_slice($max, 0, 10);
            $max = end($max);
            foreach ($newVisiting as $key => $item) {
                if ($item[2] < $max) {
                    unset($newVisiting[$key]);
                }
            }
            $visiting = $newVisiting;
        }
        $max = 0;
        $best = null;
        foreach ($visiting as $item) {
            if ($item[2] > $max) {
                $best = $item;
                $max = $item[2];
            }
        }

        return $max;
    }

    private function getNext($cur, $graph, $preasure)
    {
        $count = count(array_filter($preasure, fn($item) => $item != 0));
        if ($count > 0) {
            $result = $graph[$cur];
            if ($preasure[$cur] !== 0) {
                $result[] = $cur;
            }
        } else {
            $result = [$cur];
        }

        return $result;
    }
}
