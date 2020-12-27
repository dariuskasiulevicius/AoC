<?php

namespace AdventOfCode\Year2020\Day22;

class Model
{
    protected $id ;
    protected $deck;

    public function assign($lines)
    {
        $this->deck = [];
        foreach ($lines as $line) {
            if (false !== strpos($line, 'Player')) {
                $this->id = (int)str_replace(['Player ', ':'], ['', ''], $line);
            } else {
                $this->deck[] = (int)$line;
            }
        }
    }

    public function valid()
    {
        $result = false;


        return $result;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDeck()
    {
        return $this->deck;
    }

    /**
     * @param mixed $deck
     */
    public function setDeck($deck): void
    {
        $this->deck = $deck;
    }


}
