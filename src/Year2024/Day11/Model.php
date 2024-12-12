<?php

namespace AdventOfCode\Year2024\Day11;

class Model
{
    private ?Model $prev = null;
    private ?Model $next = null;

    public function __construct(private int $number)
    {
    }

    public function getPrev(): ?Model
    {
        return $this->prev;
    }

    public function setPrev(?Model $prev): void
    {
        $this->prev = $prev;
    }

    public function getNext(): ?Model
    {
        return $this->next;
    }

    public function setNext(?Model $next): void
    {
        $this->next = $next;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }
}
