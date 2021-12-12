<?php

namespace AdventOfCode\Year2021\Day12;

class Model
{
    private string $name;

    /** @var Model[] */
    private array $siblings = [];

    private bool $big = false;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
        if (strtoupper($name) === $name) {
            $this->big = true;
        }
    }

    public function getSiblings(): array
    {
        return $this->siblings;
    }

    public function setSiblings(array $siblings): void
    {
        $this->siblings = $siblings;
    }

    public function addSibling(Model $sibling)
    {
        $this->siblings[$sibling->getName()] = $sibling;
    }

    public function isBig(): bool
    {
        return $this->big;
    }
}
