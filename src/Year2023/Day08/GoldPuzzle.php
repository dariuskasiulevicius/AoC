<?php

namespace AdventOfCode\Year2023\Day08;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $first = true;
        $instructions = '';
        $nodes = [];
        $nodeActions = [];
        foreach ($inputData as $item) {
            if (empty($item)) {
                $first = false;
            }
            if ($first) {
                $instructions = str_split($item);
            }
            if (!$first && !empty($item)) {
                $node = new Model();
                $node->assign($item);
                $nodes[$node->getName()] = $node;
                if ($node->getLastLetter() === 'A') {
                    $nodeActions[] = $node;
                }
            }
        }

        $step = 0;
        $count = count($instructions);
        $result = 1;
        $finish = false;
        while ($finish === false) {
            $action = $instructions[$step % $count];
            $step++;
            foreach ($nodeActions as $key => $nodeAction) {
                if ($action === 'L') {
                    $nodeActions[$key] = $nodes[$nodeAction->getLeft()];
                } else {
                    $nodeActions[$key] = $nodes[$nodeAction->getRight()];
                }
                if ($nodeActions[$key]->getLastLetter() === 'Z') {
                    echo $step .PHP_EOL;
                    $result = gmp_lcm($result, $step);
                    unset($nodeActions[$key]);
                }
            }
            if (empty($nodeActions)) {
                $finish = true;
            }
        }

        return $result;
    }
}

//13019* 14681* 16343* 16897* 20221* 21883