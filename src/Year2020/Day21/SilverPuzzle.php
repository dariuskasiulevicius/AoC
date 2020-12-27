<?php

namespace AdventOfCode\Year2020\Day21;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $list = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $model = new Model();
            $model->assign($item);
            $list[] = $model;
        }

        $allIngridients = [];
        $allWords = [];
        $map = [];
        foreach ($list as $key => $item) {
            foreach ($item->getIngridients() as $ingridient) {
                if (isset($allIngridients[$ingridient])) {
                    $allIngridients[$ingridient][0]++;
                    $allIngridients[$ingridient][1][] = $key;
                } else {
                    $allIngridients[$ingridient] = [1, [$key]];
                }
            }
            foreach ($item->getList() as $aler) {
                if (isset($allWords[$aler])) {
                    $allWords[$aler]++;
                } else {
                    $allWords[$aler] = 1;
                }
            }
        }
        do {
            foreach ($allIngridients as $name => $allIngridient) {
                $freq = $this->getWordCounts($list, $allIngridient[1], array_values($map));
                $onlyOne = 0;
                $selectedWord = '';
                foreach ($freq as $word => $count) {
                    if ($count === $allIngridient[0]){
                        $onlyOne++;
                        $selectedWord = $word;
                    }
                }
                if ($onlyOne === 1){
                    $map[$name] = $selectedWord;
                    unset($allIngridients[$name]);
                }
            }
        } while (!empty($allIngridients));

        foreach ($allWords as $name => $count) {
            if (!in_array($name, $map)) {
                $result+=$count;
            }
        }

        return $result;
    }

    /**
     * @param Model[] $list
     * @param array   $rows
     * @param array   $exclude
     */
    public function getWordCounts($list, $rows, $exclude)
    {
        $result = [];
        foreach ($rows as $rowNumber) {
            foreach ($list[$rowNumber]->getList() as $item) {
                if (!in_array($item, $exclude)) {
                    if (isset($result[$item])) {
                        $result[$item]++;
                    } else {
                        $result[$item] = 1;
                    }
                }
            }
        }

        return $result;
    }
}
