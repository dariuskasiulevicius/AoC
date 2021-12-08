<?php

namespace AdventOfCode\Year2021\Day08;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $signals = explode(' | ', $item);
            $map = $this->getMap(explode(' ', $signals[0]));
            $map = array_flip($map);

            $after = explode(' ', $signals[1]);
            $num = '';
            foreach ($after as $segment) {
                $splitted = str_split($segment);
                sort($splitted);
                $segment = implode('', $splitted);
                if (isset($map[$segment])) {
                    $num .= $map[$segment];
                }
            }
            $result += (int)$num;
        }

        return $result;
    }

    private function getMap($digits)
    {
        $map = [];
        $bits = array_fill(0, 7, '');
        $left = [];
        usort($digits, [$this, 'sortByLength']);
        foreach ($digits as $digit) {
            $len = strlen($digit);
            if ($len === 2) {
                $map[1] = $digit;
                $split = str_split($digit);
                $bits[2] = $split[0];
                $bits[5] = $split[1];
            } elseif ($len === 3) {
                $map[7] = $digit;
                $bits[0] = str_replace(str_split($map[1]), '', $digit);
            } else {
                $left[] = $digit;
            }
        }

        $leftLetters = str_replace($bits, '', 'abcdefg');
        $variation = $this->getAllVariation(str_split($leftLetters), '');


        foreach ($variation as $item) {
            $letters = str_split($item);
            $candidate = [];
            foreach ($bits as $key => $value) {
                if ($value === '') {
                    $candidate[$key] = array_shift($letters);
                } else {
                    $candidate[$key] = $value;
                }
            }
            $valid = $this->isValid(array_flip($candidate), $digits);
            if ($valid) {
                break;
            }
        }

        if (!$valid) {
            $tmp = $bits[5];
            $bits[5] = $bits[2];
            $bits[2] = $tmp;
            foreach ($variation as $item) {
                $letters = str_split($item);
                $candidate = [];
                foreach ($bits as $key => $value) {
                    if ($value === '') {
                        $candidate[$key] = array_shift($letters);
                    } else {
                        $candidate[$key] = $value;
                    }
                }
                $valid = $this->isValid(array_flip($candidate), $digits);
                if ($valid) {
                    break;
                }
            }
        }


        return $valid;
    }

    public function sortByLength($a, $b)
    {
        return strlen($a) <=> strlen($b);
    }

    private function isValid($candidate, $digits)
    {
        $bitMap = [
            '1110111',
            '0100100',
            '1011101',
            '1101101',
            '0101110',
            '1101011',
            '1111011',
            '0100101',
            '1111111',
            '1101111',
        ];
        $map = array_flip(array_map('bindec', $bitMap));
        foreach ($digits as $digit) {
            $segments = 0;
            foreach (str_split($digit) as $letter) {
                $segments += 1 << $candidate[$letter];
            }
            if (isset($map[$segments])) {
                unset($map[$segments]);
            } else {
                return false;
            }
        }

        $letters = array_flip($candidate);
        $valid = [];
        foreach ($bitMap as $key => $item) {
            $code = [];
            for ($i = 0; $i < 7; $i++) {
                if ($item[6 - $i] === '1') {
                    $code[] = $letters[$i];
                }
            }
            sort($code);
            $valid[$key] = implode('', $code);
        }

        return $valid;
    }

    private function getAllVariation($letters, $part)
    {
        $result = [];
        $count = count($letters);
        for ($i = 0; $i < $count; $i++) {
            $newPart = $part . $letters[$i];
            $new = $letters;
            unset($new[$i]);
            if (!empty($new)) {
                $result = array_merge($result, $this->getAllVariation(array_values($new), $newPart));
            } else {
                $result[] = $newPart;
            }
        }

        return $result;
    }
}
