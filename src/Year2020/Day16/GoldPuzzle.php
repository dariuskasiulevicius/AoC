<?php

namespace AdventOfCode\Year2020\Day16;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $nextData = 0;
        $data = [];
        $info = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if ($item === 'your ticket:') {
                $nextData = 2;
            } elseif ($nextData === 2) {
                $ticket = explode(',', $item);
                $nextData = 0;
            } elseif ($item === 'nearby tickets:') {
                $nextData = 1;
            } elseif ($nextData === 1) {
                $new = explode(',', $item);
                if ($this->isValid($new, $info) === 0) {
                    $data[] = $new;
                }
            } elseif (!empty($item)) {
                $model = new Model();
                $model->assign($item);
                $info[] = $model;
            }
        }
        $len = count($info);
        $col = array_fill(0, $len, []);
        foreach ($data as $line) {
            foreach ($line as $key => $item) {
                $col[$key][] = $item;
            }
        }

        $resultInfo = [];
        $newTicket = [];
        do {
            $newInf = [];
            foreach ($info as $key => $validator) {
                list($valid, $colNum) = $this->allItemsValid($validator, $col);
                echo $valid . PHP_EOL;
                if ($valid === 1) {
                    $resultInfo[] = $validator;
                    unset($col[$colNum]);
                    $newTicket[] = $ticket[$colNum];
                } else {
                    $newInf[] = $validator;
                }
            }
            $info = $newInf;
        } while (count($info) > 0);


//        $len = count($info);
//        $key = 0;
//        $iter = 0;
//        do {
//            $valid = true;
//            foreach ($data as $ticket) {
//                if (!$this->isValidPosition($ticket, $info)) {
//                    $valid = false;
//                    break;
//                }
//            }
//            if ($key > ($len - 2)) {
//                $key = 0;
//            }
//            $info = $this->changeInfo($info, $key);
//            $key++;
//            $iter++;
//            echo $iter . PHP_EOL;
//        } while (!$valid);
//
        $result = 1;
        foreach ($resultInfo as $key => $item) {
            echo $key . ' ' . $item->getType() . ' ' . json_encode($item->getValues()) . PHP_EOL;
            if(false !== strpos($item->getType(), 'departure')){
                $result *=  $newTicket[$key];
            }
        }

        echo PHP_EOL;
        var_export($ticket);

        return $result;
    }

    protected function isValid($data, $validators)
    {
        $fail = 0;
        foreach ($data as $item) {
            $valid = false;
            foreach ($validators as $validator) {
                foreach ($validator->getValues() as $range) {
                    if ($item >= $range[0] && $item <= $range[1]) {
                        $valid = true;
                    }
                }
            }
            if (!$valid) {
                $fail++;
            }
        }

        return $fail;
    }

    protected function isValidPosition($data, $validators)
    {
        $key = 0;
        $valid = true;
        foreach ($validators as $validator) {
            $item = $data[$key];
            $ranges = $validator->getValues();
            if (
            !(($item >= $ranges[0][0] && $item <= $ranges[0][1])
                || ($item >= $ranges[1][0] && $item <= $ranges[1][1]))
            ) {
                $valid = false;
                break;
            }
            $key++;
        }

        return $valid;
    }

    protected function changeInfo($info, $position)
    {
        $new = [];
        foreach ($info as $key => $item) {
            if ($key === $position) {
                $new[$position + 1] = $item;
            } elseif (($key - 1) === $position) {
                $new[$position] = $item;
            } else {
                $new[$key] = $item;
            }
        }

        return $new;
    }

    protected function allItemsValid($validator, $col)
    {
        $validCol = 0;
        $validColNum = 0;
        $ranges = $validator->getValues();
        foreach ($col as $colNum => $values) {
            $valid = true;
            foreach ($values as $item) {
                if (
                !(($item >= $ranges[0][0] && $item <= $ranges[0][1])
                    || ($item >= $ranges[1][0] && $item <= $ranges[1][1]))
                ) {
                    $valid = false;
                    break;
                }
            }
            if ($valid) {
                $validCol++;
                $validColNum = $colNum;
            }
        }

        return [$validCol, $validColNum];
    }
}
