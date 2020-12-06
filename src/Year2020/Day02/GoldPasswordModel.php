<?php

namespace AdventOfCode\Year2020\Day02;

class GoldPasswordModel extends SilverPasswordModel
{
    protected int $firstPosition;
    protected int $secondPosition;

    public function isValid()
    {
        if (null === $this->password) {
            return false;
        }

        $valid = false;
        if (
            ($this->password[$this->firstPosition] === $this->char
                || $this->password[$this->secondPosition] === $this->char)
            && $this->password[$this->firstPosition] !== $this->password[$this->secondPosition]
        ) {
            $valid = true;
        }

        return $valid;
    }

    protected function parse()
    {
        parent::parse();
        if (null !== $this->minSymbol) {
            $this->firstPosition = $this->minSymbol - 1;
        }

        if (null !== $this->maxSymbol) {
            $this->secondPosition = $this->maxSymbol - 1;
        }
    }
}
