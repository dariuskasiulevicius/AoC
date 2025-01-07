<?php

namespace AdventOfCode\Year2024\Day23;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $nodes = [];
        foreach ($inputData as $item) {
            [$n1, $n2] = explode('-', $item);
            if(!isset($nodes[$n1])) {
                $nodes[$n1] = [];
            }
            $nodes[$n1][] = $n2;
            if(!isset($nodes[$n2])) {
                $nodes[$n2] = [];
            }
            $nodes[$n2][] = $n1;
        }

        $res = [];
        foreach ($nodes as $node => $connections) {
            foreach ($connections as $conn1) {
                foreach ($connections as $conn2) {
                    if ($conn1 !== $conn2 && in_array($conn2, $nodes[$conn1])) {
                        $triangle = [$node, $conn1, $conn2];
                        sort($triangle);
                        if (!in_array($triangle, $res)) {
                            $res[] = $triangle;
                        }
                    }
                }
            }
        }
        $result = [];
        foreach ($res as $re) {
            $has = false;
            foreach ($re as $item) {
                if(strpos($item, 't') === 0) {
                    $has = true;
                    break;
                }
            }
            if($has) {
                $result[] = $re;
            }
        }

        return count($result);
    }
}
