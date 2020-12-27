<?php

namespace AdventOfCode\Year2020\Day14;

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
        $mask = '';
        $mem = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $model = new Model2();
            $model->assign($item);
            if ($model->getAction() === 'mask') {
                $mask = $model->getValue();
            } elseif ($model->getAction() === 'mem') {
//                foreach ($mask['or'] as $pos) {
//                    $key = $model->getAddress() | $pos;
//                    $mem[$key] = $model->getValue();
//                }
                $key = $this->merge($mask, $model->getAddress());
                $keys = $this->getAllVariations($key);
                foreach ($keys as $key) {
                    $mem[$key] = $model->getValue();
                }
//                $mem[$model->getAddress()] = $model->getValue() & $mask['and'] | $mask['or'];
            }
        }
        $result = array_sum($mem);

        return $result;
    }

    protected function merge($a, $b)
    {
        $len = strlen($a);
        $b = str_pad($b, $len, '0',STR_PAD_LEFT);

        for ($i = 0; $i < $len; $i++) {
            if($a[$i] === 'X'){
                $b[$i] = 'X';
            } else {
                $b[$i] = $b[$i] | $a[$i];
            }
        }

        return $b;
    }

    protected function getAllVariations($string)
    {
        $len = strlen($string);
        $result = [$string];
        for ($i = 0; $i < $len; $i++) {
            $tmp = [];
            foreach ($result as $item) {
                if ($item[$i] === 'X') {
                    $a = $item;
                    $a[$i] = '0';
                    $tmp[] = $a;
                    $a = $item;
                    $a[$i] = '1';
                    $tmp[] = $a;
                } else {
                    $tmp[] = $item;
                }
            }
            $result = $tmp;
        }

        return $result;
    }
}
