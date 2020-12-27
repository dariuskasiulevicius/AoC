<?php

namespace AdventOfCode\Year2020\Day20;

class Model
{
    protected $id;
    protected $tile;
    protected $left;
    protected $right;
    protected $top;
    protected $bottom;
    protected $edges;

    public function assign(array $lines)
    {
        $this->tile = [];
        foreach ($lines as $line) {
            if (false !== strpos($line, 'Tile')) {
                $this->id = (int)str_replace(['Tile ', ':'], ['', ''], $line);
            } else {
                $this->tile[] = str_split($line, 1);
            }
        }
        $this->init();
    }

    public function init()
    {
        $this->top = implode('', $this->tile[0]);
        $this->bottom = implode('', end($this->tile));
        $this->left = [];
        $this->right = [];
        foreach ($this->tile as $item) {
            $this->left[] = $item[0];
            $this->right[] = end($item);
        }
        $this->left = implode('', $this->left);
        $this->right = implode('', $this->right);
        $edges = [];
        $edges[] = $this->getLeft();
        $edges[] = strrev($this->getLeft());
        $edges[] = $this->getRight();
        $edges[] = strrev($this->getRight());
        $edges[] = $this->getTop();
        $edges[] = strrev($this->getTop());
        $edges[] = $this->getBottom();
        $edges[] = strrev($this->getBottom());
        $this->edges = $edges;
    }

    public function rotate()
    {
        $newTile = [];
        $max = count($this->tile) - 1;
        foreach ($this->tile as $y => $yy) {
            foreach ($yy as $x => $xx) {
                $newTile[$x][$max - $y] = $xx;
            }
        }
        foreach ($newTile as $key => $line){
            ksort($line);
            $newTile[$key] = $line;
        }
        $this->tile = $newTile;
        $this->init();
    }

    public function flip()
    {
        krsort($this->tile);
        $this->tile = array_values($this->tile);
    }

    public function printTile()
    {
        echo $this->id . PHP_EOL;
        foreach ($this->tile as $item) {
            echo implode('', $item). PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function getLineWithoutEdge($x)
    {
        $line = $this->tile[$x];
        array_pop($line);
        array_shift($line);

        return implode('', $line);
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
    public function getTile()
    {
        return $this->tile;
    }

    /**
     * @param mixed $tile
     */
    public function setTile($tile): void
    {
        $this->tile = $tile;
    }

    /**
     * @return mixed
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param mixed $left
     */
    public function setLeft($left): void
    {
        $this->left = $left;
    }

    /**
     * @return mixed
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param mixed $right
     */
    public function setRight($right): void
    {
        $this->right = $right;
    }

    /**
     * @return mixed
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * @param mixed $top
     */
    public function setTop($top): void
    {
        $this->top = $top;
    }

    /**
     * @return mixed
     */
    public function getBottom()
    {
        return $this->bottom;
    }

    /**
     * @param mixed $bottom
     */
    public function setBottom($bottom): void
    {
        $this->bottom = $bottom;
    }

    /**
     * @return mixed
     */
    public function getEdges()
    {
        return $this->edges;
    }

    /**
     * @param mixed $edges
     */
    public function setEdges($edges): void
    {
        $this->edges = $edges;
    }
}
