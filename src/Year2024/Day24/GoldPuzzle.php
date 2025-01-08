<?php

namespace AdventOfCode\Year2024\Day24;

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
        $input = [];
        $empty = false;
        $actions = [];
        $highestZ = 'z00';
        foreach ($inputData as $item) {
            if ($item === '') {
                $empty = true;
                continue;
            }
            if ($empty) {
                [$action, $res] = explode(' -> ', $item);
                $actions[$res] = explode(' ', $action);
                if ($res[0] === 'z' && (int)substr($res, 1) > (int)substr($highestZ, 1)) {
                    $highestZ = $res;
                }
            } else {
                [$var, $val] = explode(':', $item);
                $input[$var] = (int)$val;
            }
        }

        $wrong = [];
        foreach ($actions as $res => $action) {
            [$op1, $op, $op2] = $action;
            if ($res[0] === 'z' && $op !== 'XOR' && $res !== $highestZ) {
                $wrong[] = $res;
            }
            if ($op === 'XOR'
            && !in_array($res[0], ['z', 'y', 'x'])
            && !in_array($op1[0], ['z', 'y', 'x'])
            && !in_array($op2[2], ['z', 'y', 'x'])
            ) {
                $wrong[] = $res;
            }
            if ($op === 'AND' && !in_array('x00', [$op1, $op2])) {
                foreach ($actions as $subres => $subaction) {
                    [$subop1, $subop, $subop2] = $subaction;
                     if (($res === $subop1 || $res === $subop2) && $subop !== 'OR') {
                         $wrong[] = $res;
                     }
                }
            }
            if ($op === 'XOR') {
                foreach ($actions as $subres => $subaction) {
                    [$subop1, $subop, $subop2] = $subaction;
                    if (($res === $subop1 || $res === $subop2) && $subop === 'OR') {
                        $wrong[] = $res;
                    }
                }
            }
        }

        $wrong = array_unique($wrong);
        sort($wrong);
        $result = implode(',', $wrong);

        return $result;
    }
}
