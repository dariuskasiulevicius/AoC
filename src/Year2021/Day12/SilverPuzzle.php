<?php

namespace AdventOfCode\Year2021\Day12;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private array $allNodes;

    private array $allPath;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $this->allNodes = [];
        foreach ($inputData as $item) {
            [$aNodeName, $bNodeName] = explode('-', $item);
            if (!isset($this->allNodes[$aNodeName])) {
                $node = new Model();
                $node->setName($aNodeName);
                $this->allNodes[$aNodeName] = $node;
            }
            $aNode = $this->allNodes[$aNodeName];

            if (!isset($this->allNodes[$bNodeName])) {
                $node = new Model();
                $node->setName($bNodeName);
                $this->allNodes[$bNodeName] = $node;
            }
            $bNode = $this->allNodes[$bNodeName];

            $aNode->addSibling($bNode);
            $bNode->addSibling($aNode);
        }

        $this->allPath = [];
        $this->go($this->allNodes['start'], [], []);

        return count($this->allPath);
    }

    /**
     * @param Model   $now
     * @param Model[] $all
     * @param bool[]  $visited
     * @return void
     */
    private function go(Model $now, array $path, array $visited): void
    {
        $path[] = $now->getName();
        $visited[$now->getName()] = true;
        if ($now->getName() === 'end') {
            $this->allPath[] = $path;
        } else {
            foreach ($now->getSiblings() as $sibling) {
                if ($sibling->isBig() || !isset($visited[$sibling->getName()])) {
                    $this->go($sibling, $path, $visited);
                }
            }
        }
    }
}
