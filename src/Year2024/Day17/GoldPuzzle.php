<?php

namespace AdventOfCode\Year2024\Day17;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private $aReg = 0;
    private $bReg = 0;
    private $cReg = 0;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = [];
        $program = [];
        foreach ($inputData as $item) {
            if (strpos($item, 'Register A: ') !== false) {
                $this->aReg = (int)str_replace('Register A: ', '', $item);
            } elseif (strpos($item, 'Register B: ') !== false) {
                $this->bReg = (int)str_replace('Register B: ', '', $item);
            } elseif (strpos($item, 'Register C: ') !== false) {
                $this->cReg = (int)str_replace('Register C: ', '', $item);
            } elseif (strpos($item, 'Program: ') !== false) {
                $program = array_map('intval', explode(',', str_replace('Program: ', '', $item)));
            }
        }

        $expected = implode('', $program);
        $power = 15;
        $from = 8 ** $power;
        do {
            $this->aReg = $from;
            $this->bReg = 0;
            $this->cReg = 0;
            $result = $this->runProgram($program);
            $got = implode('', $result);
            $found = true;
            for ($k = strlen($got) - 1; $k >= 0; $k--) {
                if ($got[$k] !== $expected[$k]) {
                    $power = $k;
                    $from += 8 ** max(0, ($power - 1));
                    $found = false;
                    break;
                }
            }
        } while (!$found);
        $result = sprintf('%f', $from);

        return $result;
    }

    private function doAction(int $instruction, int $operand): array
    {
        $bValue = 0;
        switch ($operand) {
            case 0:
            case 1:
            case 2:
            case 3:
                $bValue = $operand;
                break;
            case 4:
                $bValue = $this->aReg;
                break;
            case 5:
                $bValue = $this->bReg;
                break;
            case 6:
                $bValue = $this->cReg;
                break;
        }

        $result = 0;
        $action = null;
        switch ($instruction) {
            case 0:
                $this->aReg = floor($this->aReg / (2 ** $bValue));
                $result = null;
                break;
            case 1:
                $this->bReg = $this->bReg ^ $operand;
                $result = null;
                break;
            case 2:
                $this->bReg = $this->getModulus($bValue, 8);
                $result = null;
                break;
            case 3:
                if ($this->aReg === 0.0) {
                    $result = null;
                } else {
                    $result = $operand; //jump
                    $action = 'j';
                }
                break;
            case 4:
                $this->bReg = $this->bReg ^ $this->cReg;
                $result = null;
                break;
            case 5:
                $result = $bValue % 8; //print
                $action = 'p';
                break;
            case 6:
                $this->bReg = floor($this->aReg / (2 ** $bValue));
                $result = null;
                break;
            case 7:
                $this->cReg = floor($this->aReg / (2 ** $bValue));
                $result = null;
                break;
        }

        return [$result, $action];
    }

    function getModulus($n, $m)
    {
        $a = str_split($n);
        $r = 0;

        foreach ($a as $v) {
            $r = ((($r * 10) + (int)$v) % $m);
        }

        return $r;
    }

    /**
     * @param array $program
     * @param mixed $pointer
     * @param array $result
     * @return array
     */
    public function runProgram(array $program): array
    {
        $pointer = 0;
        $result = [];
        while (isset($program[$pointer])) {
            [$res, $action] = $this->doAction($program[$pointer], $program[$pointer + 1]);
            if ($action === 'j') {
                $pointer = $res;
            } elseif ($action === 'p') {
                $result[] = $res;
                $pointer += 2;
            } else {
                $pointer += 2;
            }
        }

        return $result;
    }
}
