<?php

namespace AdventOfCode\Year2020\Day07;

class Model
{
    protected array $bags;
    protected string $firstColor;
    protected string $code;
    protected string $firstCode;

    public function assign(string $input)
    {
        $this->code = md5($input);
        $bags = explode(' bags contain ', $input);
        $this->firstColor = $bags[0];
        $this->firstCode = md5($this->firstColor);
        $this->bags = [];
        $bags = explode(',', $bags[1]);
        foreach ($bags as $bag) {
            $bag = trim($bag);
            if (preg_match('/^([0-9]*) ([a-z]* [a-z]*) bag/', $bag, $matches)) {
                $this->bags[$matches[2]] = $matches[1];
            }
        }
    }

    public function hasBag(string $color)
    {
        foreach ($this->bags as $bagColor => $count) {
            if ($bagColor === $color) {
                return [$this->firstColor, ];
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getFirstCode(): string
    {
        return $this->firstCode;
    }

    /**
     * @return array
     */
    public function getBags(): array
    {
        return $this->bags;
    }

//    public function isValid()
//    {
//        if (in_array(
//            $this->firstColor,
//            [
//                'bright white',
//                'muted yellow',
//            ]
//        )) {
//            return true;
//        } elseif (in_array(
//            $this->firstColor,
//            [
//                'dark orange',
//                'light red',
//            ]
//        )) {
//            foreach ($this->bags as $bag) {
//                if (false !== strpos($bag, 'muted yellow')
//                    || false !== strpos($bag, 'bright white')) {
//                    return true;
//                }
//            }
//        }
//
//        return false;
//    }
}
