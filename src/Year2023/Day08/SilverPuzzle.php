<?php

namespace AdventOfCode\Year2023\Day08;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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
            }
        }

        $step = 0;
        $count = count($instructions);
        $nodeAction = $nodes['AAA'];
        while ($result === 0) {
            $action = $instructions[$step % $count];
            if ($action === 'L') {
                $nodeAction = $nodes[$nodeAction->getLeft()];
            } else {
                $nodeAction = $nodes[$nodeAction->getRight()];
            }
            $step++;
            if ($nodeAction->getName() === 'ZZZ') {
                $result = $step;
            }
        }

        return $result;
    }
}
