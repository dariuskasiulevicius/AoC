<?php

namespace AdventOfCode\Year2022\Day07;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private Model $best;

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
        $left = 70000000 - $root->getSize();
        $needs = 30000000 - $left;
        $this->best = $root;
        $this->findBest($root, $needs);

        return $this->best->getSize();
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

    private function findBest(Model $node, $needs)
    {
        foreach ($node->getStructure() as $item) {
            if (!empty($item->getStructure()) && $item->getSize() >= $needs && $item->getSize() < $this->best->getSize()) {
                $this->best = $item;
            }
            if (!empty($item->getStructure())) {
                $this->findBest($item, $needs);
            }
        }
    }
}
