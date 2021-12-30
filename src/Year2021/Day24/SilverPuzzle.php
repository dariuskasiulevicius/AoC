<?php

namespace AdventOfCode\Year2021\Day24;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $data = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $data[] = explode(' ', $item);
        }

        $w = $x = $y = $z = 0;

        $number = 0;
        $score = str_split('39999698799429');
        foreach ($data as $line) {
            $action = $line[0];
            $var1 = $line[1];
            $var2 = null;
            if (isset($line[2])) {
                $var2 = $line[2];
            }
            switch ($action) {
                case 'add':
                    if (is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 += (int)$var2;
                    } elseif (is_numeric($$var1) && is_numeric($$var2)) {
                        $$var1 += $$var2;
                    } elseif (!is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 = '(' . $$var1 . '+' . $var2 . ')';
                    } else {
                        $$var1 = '(' . $$var1 . '+' . $$var2 . ')';
                    }
                    break;
                case 'inp':
                    $$var1 = (int)$score[$number];
                    $number++;
                    break;
                case 'mul':
                    if (is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 *= (int)$var2;
                    } elseif (is_numeric($$var1) && is_numeric($$var2)) {
                        $$var1 *= $$var2;
                    } elseif (!is_numeric($$var1) && is_numeric($var2)) {
                        if ((int)$var2 === 0) {
                            $$var1 = 0;
                        } else {
                            $$var1 = '(' . $$var1 . '*' . $var2 . ')';
                        }
                    } else {
                        if ($$var1 === 0) {
                            $$var1 = 0;
                        } else {
                            $$var1 = '(' . $$var1 . '*' . $$var2 . ')';
                        }
                    }
                    break;
                case 'mod':
                    if (is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 %= (int)$var2;
                    } elseif (is_numeric($$var1) && is_numeric($$var2)) {
                        $$var1 %= $$var2;
                    } elseif (!is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 = '(' . $$var1 . '%' . $var2 . ')';
                    } else {
                        $$var1 = '(' . $$var1 . '%' . $$var2 . ')';
                    }
                    break;
                case 'div':
                    if (is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 = (int)($$var1 / (int)$var2);
                    } elseif (is_numeric($$var1) && is_numeric($$var2)) {
                        $$var1 = (int)($$var1 / $$var2);
                    } elseif (!is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 = '(int)(' . $$var1 . '/' . $var2 . ')';
                    } else {
                        $$var1 = '(int)(' . $$var1 . '/' . $$var2 . ')';
                    }
                    break;
                case 'eql':
                    if (is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 = (int)($$var1 === (int)$var2);
                    } elseif (is_numeric($$var1) && is_numeric($$var2)) {
                        $$var1 = (int)($$var1 === $$var2);
                    } elseif (!is_numeric($$var1) && is_numeric($var2)) {
                        $$var1 = '(int)(' . $$var1 . '===' . $var2 . ')';
                    } else {
                        $$var1 = '(int)(' . $$var1 . '===' . $$var2 . ')';
                    }
                    break;
            }
        }

        return $z;
    }
}
