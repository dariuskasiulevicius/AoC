<?php

namespace AdventOfCode\Year2021\Day18;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class CopySilverPuzzle implements PuzzleResolver
{
    private array $flat;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $input = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $input[] = json_decode($item, true);
        }

        $data = [];
        foreach ($input as $item) {
//            $this->flat = [];
//            $this->makeFlat($item, 0);
//            $data[] = $this->flat;


            $tmp = $this->getModelStructure($item, 0);
            $data[] = $tmp;
        }


        $tests = [
            [
                [[[[[9, 8], 1], 2], 3], 4],
                [[[[0, 9], 2], 3], 4],
            ],
            [
                [7, [6, [5, [4, [3, 2]]]]],
                [7, [6, [5, [7, 0]]]],
            ],
            [
                [[6, [5, [4, [3, 2]]]], 1],
                [[6, [5, [7, 0]]], 3],
            ],
            [
                [[3, [2, [1, [7, 3]]]], [6, [5, [4, [3, 2]]]]],
                [[3, [2, [8, 0]]], [9, [5, [7, 0]]]],
            ],
            [
                [[3, [2, [8, 0]]], [9, [5, [4, [3, 2]]]]],
                [[3, [2, [8, 0]]], [9, [5, [7, 0]]]],
            ],
        ];
        foreach ($tests as $key => $test) {
            $this->flat = [];
            $this->makeFlat($test[0], 0);
            $case = $this->flat;
            $this->print($case);
//
//            $this->flat = [];
//            $this->makeFlat($test[1], 0);
//            $expected = $this->flat;
//
//            $reduced = $this->reduce($case);
//
//            echo $key . ' > ';
//            if ($expected === $reduced) {
//                echo 'true' . PHP_EOL;
//            } else {
//                echo 'fail' . PHP_EOL;
//            }
        }

        $result = null;
        foreach ($data as $item) {
            if ($result === null) {
                $result = $item;
            } else {
                $result = $this->increaseLevel($result);
                $item = $this->increaseLevel($item);
                $result = array_merge($result, $item);
                echo json_encode($result) . PHP_EOL;
                $result = $this->reduce($result);
                $a = 3;
            }
        }

        return json_encode($result);
    }

    private function makeFlat($item, $level)
    {
        $level++;
        if (is_numeric($item[0]) && is_numeric($item[1])) {
            $this->flat[] = [$level, $item[0], $item[1]];
        } elseif (is_numeric($item[0]) && is_array($item[1])) {
            $this->flat[] = [$level, $item[0], null];
            $this->makeFlat($item[1], $level);
        } elseif (is_array($item[0]) && is_numeric($item[1])) {
            $this->makeFlat($item[0], $level);
            $this->flat[] = [$level, null, $item[1]];
        } else {
            $this->makeFlat($item[0], $level);
            $this->makeFlat($item[1], $level);
        }
    }

    private function increaseLevel($items)
    {
        $result = [];
        foreach ($items as $item) {
            $item[0]++;
            $result[] = $item;
        }

        return $result;
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
        $it = 0;
        do {
            $it++;
            $reduced = false;

            $newItems = [];
            $splitted = false;
            foreach ($items as $key => $item) {
                if (!$splitted && $item[0] > 4) {
                    //explode
                    $zero = false;
                    if (isset($items[$key - 1])) {
                        if ($items[$key - 1][2] !== null) {
                            $items[$key - 1][2] += $item[1];
                        } elseif ($items[$key - 1][1] !== null) {
                            $items[$key - 1][1] += $item[1];
                            if ($items[$key - 1][0] === $items[$key][0] - 1) {
                                $items[$key - 1][2] = 0;
                                $zero = true;
                            }
                        } else {
                            throw new Exception('unexpected error 1');
                        }
                    }
                    if (isset($items[$key + 1])) {
                        if ($items[$key + 1][1] !== null) {
                            $items[$key + 1][1] += $item[2];
                        } elseif ($items[$key + 1][2] !== null) {
                            $items[$key + 1][2] += $item[2];
                            if ($items[$key + 1][0] === $items[$key][0] - 1) {
                                $items[$key + 1][1] = 0;
                                $zero = true;
                            }
                        } else {
                            throw new Exception('unexpected error 2');
                        }
                    }
                    if ($zero) {
                        unset($items[$key]);
                        $items = array_values($items);
                    } else {
                        $items[$key] = [$item[0] - 1, 0, null];
                    }
                    $reduced = true;
                    break;
                } else {
                    //split
                    if ($splitted) {
                        $newItems[] = $item;
                    } elseif ($item[1] >= 10) {
                        $node = [$item[0] + 1, (int)floor($item[1] / 2), (int)ceil($item[1] / 2)];
                        $newItems[] = $node;
                        if ($item[2] !== null) {
                            $item[1] = null;
                            $newItems[] = $item;
                        }
                        $splitted = true;
                        $reduced = true;
                    } elseif ($item[2] >= 10) {
                        $node = [$item[0] + 1, (int)floor($item[2] / 2), (int)ceil($item[2] / 2)];
                        if ($item[1] !== null) {
                            $item[2] = null;
                            $newItems[] = $item;
                        }
                        $newItems[] = $node;
                        $splitted = true;
                        $reduced = true;
                    } else {
                        $newItems[] = $item;
                    }
                }
            }
            if ($splitted && !empty($newItems)) {
                $items = $newItems;
            }

//            //splits
//            $newItems = [];
//            $splitted = false;
//            foreach ($items as $item) {
//                if ($splitted) {
//                    $newItems[] = $item;
//                } elseif ($item[1] >= 10) {
//                    $node = [$item[0] + 1, (int)floor($item[1] / 2), (int)ceil($item[1] / 2)];
//                    $newItems[] = $node;
//                    if ($item[2] !== null) {
//                        $item[1] = null;
//                        $newItems[] = $item;
//                    }
//                    $splitted = true;
//                    $reduced = true;
//                } elseif ($item[2] >= 10) {
//                    $node = [$item[0] + 1, (int)floor($item[2] / 2), (int)ceil($item[2] / 2)];
//                    if ($item[1] !== null) {
//                        $item[2] = null;
//                        $newItems[] = $item;
//                    }
//                    $newItems[] = $node;
//                    $splitted = true;
//                    $reduced = true;
//                } else {
//                    $newItems[] = $item;
//                }
//            }
//            $items = $newItems;
            echo json_encode($items) . PHP_EOL;
        } while ($reduced);

        return $items;
    }

    private function print($items)
    {
        $level = 0;
        foreach ($items as $item) {
            for ($i = $level; $i < $item[0]; $i++) {
                echo '[';
            }
            if ($level > $item[0]) {
                echo ',';
            }
            if ($item[1] !== null) {
                echo $item[1] . ',';
            }
            if ($item[2] !== null) {
                echo $item[2] . ']';
            }
            $level--;
            for ($i = $level; $i > $item[0]; $i--) {
                echo ']';
            }
            $level = $item[0];
        }
        $level--;
        for ($i = $level; $i > 0; $i--) {
            echo ']';
        }
        echo PHP_EOL;
    }
}
