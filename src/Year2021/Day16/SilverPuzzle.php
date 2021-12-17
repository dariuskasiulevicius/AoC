<?php

namespace AdventOfCode\Year2021\Day16;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $buffer = '';
        foreach ($inputData as $item) {
            //your custom code goes here
            foreach (str_split($item) as $hex) {
                $buffer .= str_pad(decbin(hexdec($hex)), 4, '0', STR_PAD_LEFT);
            }
        }


        $packets = [$buffer];
        while(!empty($packets)) {
            $packet = array_pop($packets);
            $from = 0;
            while (strlen($packet) - $from >= 11) {
                $version = bindec(substr($packet, $from, 3));
//                echo $version . PHP_EOL;
                $result += $version;
                $from += 3;
                $type = bindec(substr($packet, $from, 3));
                $from += 3;
                if ($type === 4) {
                    $value = '';
                    do {
                        $last = substr($packet, $from, 1);
                        $from += 1;
                        $value .= substr($packet, $from, 4);
                        $from += 4;
                    } while ($last);
                } else {
                    $length = bindec(substr($packet, $from, 1));
                    $from += 1;
                    if ($length === 0) {
                        $fullAction = bindec(substr($packet, $from, 15));
                        $from += 15;
                        $packets[] = substr($packet, $from, $fullAction);
                        $from += $fullAction;
                    } else {
                        $packetCount = bindec(substr($packet, $from, 11));
                        $from += 11;
                        $packets[] = substr($packet, $from);
                        $from = strlen($packet);
                    }
                }
            }
        }

        return $result;
    }
}
