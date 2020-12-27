<?php

namespace AdventOfCode\Year2020\Day08;

class Model
{
    protected string $operation;
    protected int $count;
    protected bool $visited = false;

    public function assign(string $line)
    {
        $exploded = explode(' ', $line);
        $this->operation = $exploded[0];
        $this->count = (int) $exploded[1];
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->visited;
    }

    /**
     * @param bool $visited
     */
    public function setVisited(bool $visited): void
    {
        $this->visited = $visited;
    }
}
