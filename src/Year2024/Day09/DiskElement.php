<?php

namespace AdventOfCode\Year2024\Day09;

class DiskElement
{
    private DiskElement|null $next = null;
    private DiskElement|null $prev = null;

    private bool $moved = false;

    public function __construct(private ?int $id, private int $count)
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getNext(): ?DiskElement
    {
        return $this->next;
    }

    public function setNext(?DiskElement $next): void
    {
        $this->next = $next;
    }

    public function getPrev(): ?DiskElement
    {
        return $this->prev;
    }

    public function setPrev(?DiskElement $prev): void
    {
        $this->prev = $prev;
    }

    public function isMoved(): bool
    {
        return $this->moved;
    }

    public function setMoved(bool $moved): void
    {
        $this->moved = $moved;
    }
}