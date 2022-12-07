<?php

namespace AdventOfCode\Year2022\Day07;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $root = new Model();
        $root->setName('/');
        $buffer = [];
        $current = $root;
        foreach ($inputData as $item) {
            //your custom code goes here
            if ($item[0] === '$') {
                $parameters = explode(' ', $item);
                if ($parameters[1] === 'cd') {
                    if ($parameters[2] === '/') {
                        $buffer = [$root];
                    } elseif ($parameters[2] === '..') {
                        array_pop($buffer);
                    } else {
                        $current = end($buffer);
                        $buffer[] = $current->getNodeByName($parameters[2]);
                    }
                } elseif ($parameters[1] === 'ls') {
                    $current = end($buffer);
                } else {
                    echo 'Command not found';
                    exit(255);
                }
            } else {
                $parameters = explode(' ', $item);
                if ($parameters[0] === 'dir') {
                    $node = new Model();
                    $node->setName($parameters[1]);
                    $current->add($node);
                } else {
                    $node = new Model();
                    $node->setName($parameters[1]);
                    $node->setSize($parameters[0]);
                    $current->add($node);
                }
            }
        }

        $this->calculateSize($root);

        return $this->getSum($root);
    }

    private function calculateSize(Model $node)
    {
        $size = 0;
        foreach ($node->getStructure() as $item) {
            if ($item->getSize() === 0) {
                $this->calculateSize($item);

            }
            $size += $item->getSize();
        }
        $node->setSize($size);
    }

    private function getSum(Model $node)
    {
        $size = 0;
        foreach ($node->getStructure() as $item) {
            if (!empty($item->getStructure())) {
                $size += $this->getSum($item);
                if ($item->getSize() <= 100000) {
                    $size += $item->getSize();
                }
            }

        }

        return $size;
    }
}
