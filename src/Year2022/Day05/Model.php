<?php

namespace AdventOfCode\Year2022\Day05;

class Model
{
    private string $value;
    private ?Model $next = null;

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getNext(): ?Model
    {
        return $this->next;
    }

    public function setNext(?Model $next): void
    {
        $this->next = $next;
    }

    public function getLast()
    {
        if ($this->next !== null){
            return $this->next->getLast();
        }

        return $this;
    }
}
