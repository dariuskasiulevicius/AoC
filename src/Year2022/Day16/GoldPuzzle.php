<?php

namespace AdventOfCode\Year2022\Day16;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

//(You guessed 2623.)That's not the right answer; your answer is too low. If you're stuck, make sure you're using the full input data; there are also some general tips on the about page, or you can ask for hints on the subreddit. Please wait one minute before trying again. (You guessed 2623.)
class GoldPuzzle implements PuzzleResolver
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
        $visiting = [[[$start, $start], 0, 0, $pressure, []]];
        for ($t = 0; $t < 26; $t++) {
            echo 't ' . $t . ' c ' . count($visiting) . PHP_EOL;
            $newVisiting = [];
            $max = [];
            foreach ($visiting as $cur) {
                $cur[2] += $cur[1];
                $nexts = $this->getNext($cur[0], $graph, $cur[3]);
                foreach ($nexts as $next) {
                    $xx = $cur;

                    if ($next[0] === $xx[0][0]) {
                        $xx[1] += $cur[3][$next[0]];
                        $xx[3][$next[0]] = 0;
                    }
                    $xx[0][0] = $next[0];
                    $xx[4][] = $cur[0];

                    if ($next[1] === $xx[0][1]) {
                        $xx[1] += $cur[3][$next[1]];
                        $xx[3][$next[1]] = 0;
                    }
                    $xx[0][1] = $next[1];
                    $xx[4][] = $cur[0];
                    $newVisiting[] = $xx;

                    $max[$xx[2]] = true;
                }
            }
            $max = array_keys($max);
            rsort($max);
            $max = array_slice($max, 0, 21);
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

            $aSide = $graph[$cur[0]];
            if ($preasure[$cur[0]] !== 0) {
                $aSide[] = $cur[0];
            }
            $bSide = $graph[$cur[1]];
            if ($preasure[$cur[1]] !== 0) {
                $bSide[] = $cur[1];
            }
            $result = [];
            $diff = [];
            foreach ($aSide as $aa) {
                foreach ($bSide as $bb) {
                    if ($aa !== $bb && !in_array($aa . ';' . $bb, $diff)) {
                        $result[] = [$aa, $bb];
                        $diff[$aa . ';' . $bb] = 1;
                        $diff[$bb . ';' . $aa] = 1;
                    }
                }
            }
        } else {
            $result = [$cur];
        }

        return $result;
    }
}
