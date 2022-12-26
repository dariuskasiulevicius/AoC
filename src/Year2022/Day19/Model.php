<?php

namespace AdventOfCode\Year2022\Day19;

class Model
{
    private string $parentName = '';
    private int $number;
    /**
     * @var int[] [ore, clay, obsidian, geode]
     */
    private $warehouse = [0, 0, 0, 0];
    private $robots = [1, 0, 0, 0];

    private $skipBuild = [];
    private $prices = [
    ];

    public function getKey()
    {
        return json_encode([
            'id' => spl_object_id($this),
            'p' => $this->parentName,
            'w' => $this->warehouse,
            'r' => $this->robots,
            's' => $this->skipBuild
        ], JSON_THROW_ON_ERROR);
    }

    public function getShortKey()
    {
        return json_encode([
            'r' => $this->robots,
        ], JSON_THROW_ON_ERROR);
    }

    public function getGeodes()
    {
        return $this->warehouse[3];
    }

    public function howManyRobotsCanBuild($needed): float
    {
        $result = PHP_INT_MAX;
        foreach ($needed as $key => $value) {
            if ($value !== 0) {
                $result = min($result, $this->warehouse[$key] / $value);
            }
        }

        return $result;
    }

    public function minusResources($resources)
    {
        foreach ($resources as $key => $value) {
            $this->warehouse[$key] -= $value;
        }
    }

    public function addResources($resources)
    {
        foreach ($resources as $key => $value) {
            $this->warehouse[$key] += $value;
        }
    }

    public function addRobot($number)
    {
        $this->robots[$number]++;
    }

    public function getRobots(): array
    {
        return $this->robots;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getPrices(): array
    {
        return $this->prices;
    }

    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
    }

    public function getSkipBuild()
    {
        return $this->skipBuild;
    }

    public function setSkipBuild($skipBuild): void
    {
        $this->skipBuild = $skipBuild;
    }

    public function addSkipBuild($skip)
    {
        $this->skipBuild[] = $skip;
    }

    /**
     * @return string
     */
    public function getParentName(): string
    {
        return $this->parentName;
    }

    /**
     * @param string $parentName
     */
    public function setParentName(string $parentName): void
    {
        $this->parentName = $parentName;
    }
}
