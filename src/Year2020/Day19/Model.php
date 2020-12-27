<?php

namespace AdventOfCode\Year2020\Day19;

class Model
{
    protected $id;
    protected $patterns;
    protected $variations;

    public function assign(string $line)
    {
        $pattern = '/^(\d+):([ 0-9\|]*)$/';
        $pattern3 = '/^(\d+): "(.)"$/';
        if (preg_match($pattern3, $line, $matches)) {
            $this->id = $matches[1];
            $this->variations = [$matches[2]];
        } elseif (preg_match($pattern, $line, $matches)) {
            $this->id = $matches[1];
            $vars = explode('|', $matches[2]);
            $this->patterns = [];
            foreach ($vars as $var) {
                $this->patterns[] = explode(' ', trim($var));
            }
        } else {
            throw new \Exception($line);
        }
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
    public function getPatterns()
    {
        return $this->patterns;
    }

    /**
     * @param mixed $patterns
     */
    public function setPatterns($patterns): void
    {
        $this->patterns = $patterns;
    }

    /**
     * @return mixed
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * @param mixed $variations
     */
    public function setVariations($variations): void
    {
        $this->variations = $variations;
    }
}
