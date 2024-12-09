<?php

namespace AdventOfCode\Year2024\Day09;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private array $disk = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $file = true;
            $count = 0;
            foreach (str_split($item) as $char) {
                if ($file) {
                    $file = false;
                    $this->disk[] = [$count, (int)$char];
                    $count++;
                } else {
                    $this->disk[] = ['', (int)$char];
                    $file = true;
                }
            }
        }
        $formattedDisk = [];
        $count = count($this->disk);
        $lastFile = null;

        do {
            $file = array_shift($this->disk);
            if ($file[0] == '') {
                if ($file[1] > 0) {
                    $spaceCount = $file[1];
                    do {
                        if ($lastFile === null) {
                            $lastFile = $this->getLastFile();
                            if ($lastFile === null) {
                                break;
                            }
                        }
                        if ($spaceCount >= $lastFile[1]) {
                            $spaceCount -= $lastFile[1];
                            $formattedDisk[] = $lastFile;
                            $lastFile = null;
                        } else {
                            $formattedDisk[] = [$lastFile[0], $spaceCount];
                            $lastFile[1] -= $spaceCount;
                            $spaceCount = 0;
                        }
                    } while ($spaceCount > 0);
                }
            } else {
                $formattedDisk[] = $file;
            }
        } while (count($this->disk) > 0);

        if ($lastFile !== null) {
            $formattedDisk[] = $lastFile;
        }
        $position = 0;
        foreach ($formattedDisk as $file) {
            for ($i = 0; $i < $file[1]; $i++) {
                $result += $position * $file[0];
                $position++;
            }
        }

        return $result;
    }

    private function getLastFile()
    {
        if (count($this->disk) === 0) {
            return null;
        }
        do {
            $file = array_pop($this->disk);
        } while ($file[0] === '' && count($this->disk) > 0);

        return $file;
    }
}
