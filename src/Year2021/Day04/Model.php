<?php

namespace AdventOfCode\Year2021\Day04;

class Model
{
    private array $lines = [];
    private array $rows = [];

    public function assign(string $line): void
    {
        preg_match('/(\d+)[^\d]+(\d+)[^\d]+(\d+)[^\d]+(\d+)[^\d]+(\d+)/', $line, $matches);
        array_shift($matches);
        $this->lines[] = array_map('intval', $matches);
        foreach (end($this->lines) as $key => $num) {
            if (!isset($this->rows[$key])) {
                $this->rows[$key] = [];
            }
            $this->rows[$key][] = $num;
        }
    }

    public function markNumber(int $number): void
    {
        foreach ($this->lines as $lineNr => $line) {
            foreach ($line as $key => $item) {
                if ($item === $number) {
                    $this->lines[$lineNr][$key] = -1;
                }
            }
        }
        foreach ($this->rows as $rowNr => $row) {
            foreach ($row as $key => $item) {
                if ($item === $number) {
                    $this->rows[$rowNr][$key] = -1;
                }
            }
        }
    }

    public function isWinner(): bool
    {
        $winner = false;
        foreach ($this->lines as $line) {
            if (-5 === array_sum($line)) {
                $winner = true;
                break;
            }
        }
        if (false === $winner) {
            foreach ($this->rows as $row) {
                if (-5 === array_sum($row)) {
                    $winner = true;
                    break;
                }
            }
        }

        return $winner;
    }

    public function leftSum(): int
    {
        $sum = 0;
        foreach ($this->lines as $line) {
            foreach ($line as $item) {
                if (-1 !== $item) {
                    $sum += $item;
                }
            }
        }

        return $sum;
    }
}
