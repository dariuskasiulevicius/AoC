<?php

namespace AdventOfCode\Year2024\Day24;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $input = [];
        $empty = false;
        $actions = [];
        foreach ($inputData as $item) {
            if ($item === '') {
                $empty = true;
                continue;
            }
            if ($empty) {
                [$action, $result] = explode(' -> ', $item);
                $actions[$result] = explode(' ', $action);
            } else {
                [$var, $val] = explode(':', $item);
                $input[$var] = (int)$val;
            }
        }

        do {
            $firstKey = array_key_first($actions);
            $firstAction = array_shift($actions);
            if(isset($input[$firstAction[0]], $input[$firstAction[2]])){
                switch ($firstAction[1]) {
                    case 'AND':
                        $input[$firstKey] = $input[$firstAction[0]] & $input[$firstAction[2]];
                        break;
                    case 'OR':
                        $input[$firstKey] = $input[$firstAction[0]] | $input[$firstAction[2]];
                        break;
                    case 'XOR':
                        $input[$firstKey] = $input[$firstAction[0]] ^ $input[$firstAction[2]];
                        break;
                }
            } else {
                $actions[$firstKey] = $firstAction;
            }

        } while (count($actions) > 0);

        $zets = [];
        foreach ($input as $key => $item) {
            if (strpos($key, 'z') === 0) {
                $zets[$key] = $item;
            }
        }
        krsort($zets);
        $bin = implode('', $zets);
        $result = bindec($bin);

        return $result;
    }
}
