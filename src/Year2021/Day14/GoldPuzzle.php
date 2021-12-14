<?php

namespace AdventOfCode\Year2021\Day14;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            if (strpos($item, '->') !== false) {
                [$from, $to] = explode(' -> ', $item);
                $actions[$from] = $to;
            } elseif (!empty($item)) {
                $polymer = $item;
            }
        }
        $counts = [];
        $length = strlen($polymer) - 1;
        $pairs = [];
        for ($i = 0; $i < $length; $i++) {
            $left = $polymer[$i];
            $counts[$left] = ($counts[$left] ?? 0) + 1;
            $right = $polymer[$i + 1];
            $pair = $left . $right;
            $pairs[$pair] = ($pairs[$pair] ?? 0) + 1;
        }
        $counts[$right] = ($counts[$right] ?? 0) + 1;

        for ($step = 0; $step < 40; $step++) {
            $newPairs = [];
            foreach ($pairs as $pair => $count) {
                $newLetter = $actions[$pair];
                $counts[$newLetter] = ($counts[$newLetter] ?? 0) + $count;
                $left = $pair[0] . $newLetter;
                $newPairs[$left] = ($newPairs[$left] ?? 0) + $count;
                $right = $newLetter . $pair[1];
                $newPairs[$right] = ($newPairs[$right] ?? 0) + $count;
            }
            $pairs = $newPairs;
        }

        sort($counts);

        return end($counts) - $counts[0];
    }
}

//first try
//        $result = 0;
//        $actions = [];
//        foreach ($inputData as $item) {
//            if (strpos($item, '->') !== false) {
//                [$from, $to] = explode(' -> ', $item);
//                $point = new Model();
//                $point->setLetter($to);
//                $actions[$from] = $point;
//            } elseif (!empty($item)) {
//                $polymer = $item;
//            }
//        }
//        $start = null;
//        $prev = null;
//        foreach (str_split($polymer) as $letter) {
//            $point = new Model();
//            $point->setLetter($letter);
//            if ($start === null) {
//                $start = $point;
//            } elseif ($prev !== null) {
//                $prev->setNext($point);
//            }
//            $prev = $point;
//        }
//
//        for ($step = 0; $step < 40; $step++) {
//            $current = $start;
//            do {
//                $next = $current->getNext();
//                $pair = $current->getLetter() . $next->getLetter();
//                $insert = clone $actions[$pair];
//                $insert->setNext($next);
//                $current->setNext($insert);
//
//                $current = $next;
//            } while ($current->getNext());
//            echo $step . PHP_EOL;
//        }
//
//        $counts = [];
//        $current = $start;
//        do {
//            $letter = $current->getLetter();
//            if (!isset($counts[$letter])) {
//                $counts[$letter] = 0;
//            }
//            $counts[$letter]++;
//            $current = $current->getNext();
//        } while ($current);
//
//        sort($counts);
//
//        return end($counts) - $counts[0];


//second try
//{
//    foreach ($inputData as $item) {
//        if (strpos($item, '->') !== false) {
//            [$from, $to] = explode(' -> ', $item);
//            $this->actions[$from] = $to;
//            $this->counts[$to] = 0;
//        } elseif (!empty($item)) {
//            $polymer = $item;
//        }
//    }
//
//    $iteration = 0;
//    $length = strlen($polymer) - 1;
//    for($i = 0; $i < $length; $i ++) {
//        $left = $polymer[$i];
//        $right = $polymer[$i+1];
//        $this->dive($left, $right, $iteration);
//        $this->counts[$left]++;
//    }
//    $this->counts[$right]++;
//
//    sort($this->counts);
//
//    return end($this->counts) - $this->counts[0];
//}
//
//private function dive($left, $right, $iteration)
//{
//    $newLetter = $this->actions[$left.$right];
//    $this->counts[$newLetter]++;
//    $iteration++;
//    if ($iteration >= $this->limit) {
//        return;
//    }
//    $this->dive($left, $newLetter, $iteration);
//    $this->dive($newLetter, $right, $iteration);
//}


//third try
//{
//    foreach ($inputData as $item) {
//        if (strpos($item, '->') !== false) {
//            [$from, $to] = explode(' -> ', $item);
//            $this->actions[$from] = $to;
//            $this->counts[$to] = 0;
//        } elseif (!empty($item)) {
//            $polymer = $item;
//        }
//    }
//
//    $iteration = 0;
//    $length = strlen($polymer) - 1;
//    $pairs = [];
//    for ($i = 0; $i < $length; $i++) {
//        $left = $polymer[$i];
//        $right = $polymer[$i + 1];
//        $pairs[] = [$left, $right, $iteration];
//        $this->counts[$left]++;
//    }
//    $this->counts[$right]++;
//
//    while (!empty($pairs)) {
//        $pair = array_pop($pairs);
//        $newLetter = $this->actions[$pair[0] . $pair[1]];
//        $this->counts[$newLetter]++;
//        $iteration = $pair[2] + 1;
//        if ($iteration < $this->limit) {
//            array_push($pairs, [$pair[0], $newLetter, $iteration]);
//            array_push($pairs, [$newLetter, $pair[1], $iteration]);
//        }
//    }
//
//
//    sort($this->counts);
//
//    return end($this->counts) - $this->counts[0];
//}