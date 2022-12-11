<?php

namespace AdventOfCode\Year2022\Day11;

class Model
{
    private array $items = [];
    private int $correct = 0;
    private int $wrong = 0;

    private int $test = 0;
    private string $operation = '';

    private int $inspected = 0;

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(int $item)
    {
        $this->items[] = $item;
    }

    public function getCorrect(): int
    {
        return $this->correct;
    }

    public function setCorrect(int $correct): void
    {
        $this->correct = $correct;
    }

    public function getWrong(): int
    {
        return $this->wrong;
    }

    public function setWrong(int $wrong): void
    {
        $this->wrong = $wrong;
    }

    public function getTest(): int
    {
        return $this->test;
    }

    public function setTest(int $test): void
    {
        $this->test = $test;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation . ';';
    }

    public function doOperation(int $old)
    {
        $new = 0;
        eval($this->operation);

        return $new;
    }

    public function getRedirection( $number)
    {
        if((int)$number % $this->test === 0){
            return $this->correct;
        }
        return $this->wrong;
    }

    public function getInspected(): int
    {
        return $this->inspected;
    }

    public function increaseInspected()
    {
        $this->inspected++;
    }
}
