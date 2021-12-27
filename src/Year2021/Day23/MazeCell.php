<?php

namespace AdventOfCode\Year2021\Day23;

class MazeCell
{
    const HALLWAY = 'hall';
    const A_ROOM = Model::Model_A;
    const B_ROOM = Model::Model_B;
    const C_ROOM = Model::Model_C;
    const D_ROOM = Model::Model_D;
    private int $id;
    private string $type;
    private bool $canStop;
    private array $siblings = [];
    private ?Model $content = null;

    public function __clone(): void
    {
        $new = [];
        foreach ($this->siblings as $sibling) {
            $new[] = clone $sibling;
        }
        $this->siblings = $new;
        $this->content = clone $this->content;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isCanStop(): bool
    {
        return $this->canStop;
    }

    /**
     * @param bool $canStop
     */
    public function setCanStop(bool $canStop): void
    {
        $this->canStop = $canStop;
    }

    /**
     * @return MazeCell[]
     */
    public function getSiblings(): array
    {
        return $this->siblings;
    }

    /**
     * @param MazeCell[] $siblings
     */
    public function setSiblings(array $siblings): void
    {
        $this->siblings = $siblings;
    }

    /**
     * @return Model|null
     */
    public function getContent(): ?Model
    {
        return $this->content;
    }

    /**
     * @param Model|null $content
     */
    public function setContent(?Model $content): void
    {
        $this->content = $content;
    }

    public function addSibling(MazeCell $sibling)
    {
        $this->siblings[] = $sibling;
    }
}
