<?php

namespace AdventOfCode\Year2021\Day18;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $input = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $input[] = json_decode($item, true);
        }

        $maxSum = 0;
        foreach ($input as $i => $iValue) {
            foreach ($input as $j => $jValue) {
                if ($i === $j) {
                    continue;
                }
                $left = $this->getModelStructure($iValue, 0);
                $right = $this->getModelStructure($jValue, 0);

                $this->increaseLevel($left);
                $this->increaseLevel($right);
                $node = new Model();
                $node->setLevel(1);
                $node->setLeft($left);
                $node->setRight($right);
                $left->setParent($node);
                $right->setParent($node);
                $this->reduce($node);
                $sum = $this->calculate($node, null);
                $maxSum = max($maxSum, $sum);
            }
        }

        return $maxSum;
    }

    private function calculate(Model $node, ?Model $parent)
    {
        if ($node->getLeft() instanceof Model) {
            $this->calculate($node->getLeft(), $node);
        }
        if ($node->getRight() instanceof Model) {
            $this->calculate($node->getRight(), $node);
        }
        if ($parent !== null && $parent->getLeft() === $node) {
            $parent->setLeft($node->getLeft() * 3 + $node->getRight() * 2);
        }
        if ($parent !== null && $parent->getRight() === $node) {
            $parent->setRight($node->getLeft() * 3 + $node->getRight() * 2);
        }
        if ($parent === null) {
            return $node->getLeft() * 3 + $node->getRight() * 2;
        }

        return null;
    }

    private function increaseLevel(Model $items)
    {
        $items->increaseLevel();
        if ($items->getLeft() instanceof Model) {
            $this->increaseLevel($items->getLeft());
        }
        if ($items->getRight() instanceof Model) {
            $this->increaseLevel($items->getRight());
        }
    }

    private function getModelStructure($item, $level)
    {
        if (is_numeric($item)) {
            return $item;
        }
        $level++;
        $node = new Model();
        $node->setLevel($level);
        $left = $this->getModelStructure($item[0], $level);
        if ($left instanceof Model) {
            $left->setParent($node);
        }
        $right = $this->getModelStructure($item[1], $level);
        if ($right instanceof Model) {
            $right->setParent($node);
        }
        $node->setLeft($left);
        $node->setRight($right);

        $this->flat[] = $node;

        return $node;
    }

    private function reduce($items)
    {
        do {
            $reduced = false;
            //explode
            $node = $this->getBigger($items);
            if ($node instanceof Model) {
                $parent = $node->getParent();
                [$leftNode, $side] = $this->getLeftNode($parent, $node);
                $getter = 'get' . $side;
                $setter = 'set' . $side;
                if ($leftNode !== null && !($leftNode->$getter() instanceof Model)) {
                    $leftNode->$setter($leftNode->$getter() + $node->getLeft());
                } elseif ($leftNode !== null && $leftNode->$getter() instanceof Model) {
                    throw new \Exception('Error 5');
                }

                [$rightNode, $side] = $this->getRightNode($parent, $node);
                $getter = 'get' . $side;
                $setter = 'set' . $side;
                if ($rightNode !== null && !($rightNode->$getter() instanceof Model)) {
                    $rightNode->$setter($rightNode->$getter() + $node->getRight());
                } elseif ($rightNode !== null && $rightNode->$getter() instanceof Model) {
                    throw new \Exception('Error 6');
                }

                if ($parent->getLeft() === $node) {
                    $parent->setLeft(0);
                }
                if ($parent->getRight() === $node) {
                    $parent->setRight(0);
                }

                $reduced = true;
                continue;
            }

            //split
            [$node, $side] = $this->getForSplit($items);
            $getter = 'get' . $side;
            $setter = 'set' . $side;
            if ($node instanceof Model) {
                $value = $node->$getter();
                $newNode = new Model();
                $newNode->setLevel($node->getLevel() + 1);
                $newNode->setLeft((int)floor($value / 2));
                $newNode->setRight((int)ceil($value / 2));
                $newNode->setParent($node);
                $node->$setter($newNode);
                $reduced = true;
            }
        } while ($reduced);
    }

    private function getLeftNode($node, $prevNode): array
    {
        if ($node->getLeft() !== $prevNode) {
            if ($node->getLeft() instanceof Model) {
                return [$this->getRightNodeUp($node->getLeft()), 'Right'];
            }

            return [$node, 'Left'];
        }

        if ($node->getParent() !== null) {
            return $this->getLeftNode($node->getParent(), $node);
        }

        return [null, null];
    }

    private function getRightNode($node, $prevNode): array
    {
        if ($node->getRight() !== $prevNode) {
            if ($node->getRight() instanceof Model) {
                return [$this->getLeftNodeUp($node->getRight()), 'Left'];
            }

            return [$node, 'Right'];
        }

        if ($node->getParent() !== null) {
            return $this->getRightNode($node->getParent(), $node);
        }

        return [null, null];
    }

    private function getRightNodeUp($node): ?Model
    {
        if ($node->getRight() instanceof Model) {
            return $this->getRightNodeUp($node->getRight());
        }

        return $node;
    }

    private function getLeftNodeUp($node): ?Model
    {
        if ($node->getLeft() instanceof Model) {
            return $this->getLeftNodeUp($node->getLeft());
        }

        return $node;
    }

    private function getForSplit(Model $node)
    {
        $result = [null, null];
        if ($result[0] === null && $node->getLeft() instanceof Model) {
            $result = $this->getForSplit($node->getLeft());
        } elseif ($result[0] === null && $node->getLeft() >= 10) {
            return [$node, 'Left'];
        }
        if ($result[0] === null && $node->getRight() instanceof Model) {
            $result = $this->getForSplit($node->getRight());
        } elseif ($result[0] === null && $node->getRight() >= 10) {
            return [$node, 'Right'];
        }

        return $result;
    }

    private function getBigger($item)
    {
        if ($item->getLevel() > 4) {
            return $item;
        }
        $node = null;
        if ($item->getLeft() instanceof Model) {
            $node = $this->getBigger($item->getLeft());
        }
        if ($node instanceof Model) {
            return $node;
        }

        $node = null;
        if ($item->getRight() instanceof Model) {
            $node = $this->getBigger($item->getRight());
        }
        if ($node instanceof Model) {
            return $node;
        }

        return null;
    }

    private function print($node)
    {
        if ($node instanceof Model) {
            echo '[';
            $this->print($node->getLeft());
            echo ',';
            $this->print($node->getRight());
            echo ']';
        } else {
            echo $node;
        }
    }
}
