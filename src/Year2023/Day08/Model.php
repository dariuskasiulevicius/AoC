<?php

namespace AdventOfCode\Year2023\Day08;

class Model
{
    private string $name;
    private string $left;
    private string $right;
    private string $lastLetter;

    public function assign(string $line)
    {
        [$name, $nodes] = explode(' = ', $line);
        $this->name = $name;
        $this->lastLetter = substr($name, -1);
        $nodes = str_replace(['(', ')'], ['', ''], $nodes);
        [$left, $right] = explode(', ', $nodes);
        $this->left = $left;
        $this->right = $right;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastLetter(): string
    {
        return $this->lastLetter;
    }

    public function getLeft(): string
    {
        return $this->left;
    }

    public function getRight(): string
    {
        return $this->right;
    }
}
