<?php

namespace AdventOfCode\Year2020\Day13;

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
        $buses = [];
        $dif = [];
        foreach ($inputData as $item) {
//            //your custom code goes here
            $tmp = explode(',', $item);
//
        }
        $position = 100000000000000;
        $j = 0;
        foreach ($tmp as $bus) {
            if ($bus !== 'x') {
                $buses[] = [(int)$bus, (int)$bus, $j];
                $position = max($position, $bus);
                echo sprintf("(n+%d)%%%d = 0,", $j, $bus);
            }
            $j++;
        }
//        for (int i = 0; i < splitEntries.size(); ++i) {
//        if (splitEntries[i] != "x") {
//            int bus = atoi(splitEntries[i].c_str());
//			Info("(n+%d)%%%d = 0,", i, bus);
//		}
//    }
die;
        $len = count($buses);
        $col = 0;
        $it = 0;
        while ($len > $col) {
            $position = $this->nextStep($buses, $position, $col);
//            for ($i = 0; $i < $len; $i++) {
//                $buses[$i][1] += $buses[$i][0];
//            }
            foreach ($buses as $key => $bus) {
                $buses[$key][1] = ceil($position / $bus[0]) * $bus[0];
            }
            $col = $this->isValid($buses);
            $position = $buses[$col][1];
            $position++;
            if($col>0) {
                $col++;
            }
            $it ++;
            if ($it % 1000000 === 0) {
            echo $buses[0][1];
            echo PHP_EOL;
            }
        }
        $result = $buses[0][1];


        return $result;
    }

    protected function isValid(array $buses)
    {
        $bus = $buses[0];
        $len = count($buses);
        $position = 0;
        for ($i = 1; $i < $len; $i++) {
            if ($bus[1] + $buses[$i][2] == $buses[$i][1]) {
//                $bus = $buses[$i];
                $position++;
            } else {
                break;
            }
        }

        return $position;
    }

    protected function nextStep($buses, $dep, $i)
    {
        $bus = $buses[$i][0];
        $small = ceil($dep / $bus);
        $busFrom = $small * $bus;

        return $busFrom;
    }
}
