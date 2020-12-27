<?php

namespace AdventOfCode\Year2020\Day20;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    protected $map;
    protected $tiles;
    protected $counts;
    protected $edges;
    protected $hugeMap;
    protected $found = 0;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $this->tiles = [];
        $tile = [];
        foreach ($inputData as $item) {
            if (!empty($item)) {
                $tile[] = $item;
            } else {
                $model = new Model();
                $model->assign($tile);
                $this->tiles[$model->getId()] = $model;
                $tile = [];
            }
        }
        if (!empty($tile)) {
            $model = new Model();
            $model->assign($tile);
            $this->tiles[$model->getId()] = $model;
        }

        $this->edges = [];
        $this->counts = [];
        foreach ($this->tiles as $tile) {
            $id = $tile->getId();
            $this->counts[$id] = 0;
            foreach ($tile->getEdges() as $edge) {
                if (isset($this->edges[$edge])) {
                    $this->edges[$edge][] = $id;
                    foreach ($this->edges[$edge] as $key) {
                        $this->counts[$key]++;
                    }
                } else {
                    $this->edges[$edge] = [$id];
                }
            }
        }
        $this->map[0][0] = array_pop($this->tiles);
//        $this->map[0][0]->printTile();
        $y = 0;
        $x = 0;

        $this->growMap($x, $y);

        foreach ($this->map as $key => $item) {
            ksort($item);
            $this->map[$key] = $item;
        }
        ksort($this->map);
        $result = 0;

        $this->hugeMap = [];
        $line = 0;
        foreach ($this->map as $items) {
            for ($y = 1; $y < 9; $y++) {
                $this->hugeMap[$line] = '';
                foreach ($items as $item) {
//                    $this->hugeMap[$line] .= $item->getLineWithoutEdge($y);
                    $this->hugeMap[$line] .= str_replace(['.', '#'], ['0', '1'], $item->getLineWithoutEdge($y));
                }
                $line++;
            }
        }

//        foreach ($this->hugeMap as $item) {
//            echo strlen($item) . PHP_EOL;
//        }
        $seeMonster = [
            bindec('00000000000000000010'),
            bindec('10000110000110000111'),
            bindec('01001001001001001000'),
        ];
        $inversMonster = [
            bindec('11111111111111111101'),
            bindec('01111001111001111000'),
            bindec('10110110110110110111'),
        ];

        $ylen = count($this->hugeMap) - 3;
        $xlen = strlen($this->hugeMap[0]) - 20;
        $hMap = new Model();
        $hMap->assign($this->hugeMap);
//        $hMap->printTile();
        $rotate = 0;
        $flip = 0;
        do {
            $fits = false;
            for ($y = 0; $y <= $ylen; $y++) {
                for ($x = 0; $x <= $xlen; $x++) {
                    $newFits = $this->markSeeMonster($seeMonster, $x, $y, $inversMonster);
                    $fits = $fits || $newFits;
//                    if ($newFits){
//                        $stop =true;
//                    }
                }
            }
            if(!$fits) {
                if ($rotate < 4) {
                    $hMap->rotate();
                    $rotate++;
                } elseif ($flip === 0) {
                    $hMap->flip();
                    $flip++;
                    $rotate = 0;
                } else {
                    throw new \Exception('Not found match');
                }
                foreach ($hMap->getTile() as $key => $tile) {
                    $this->hugeMap[$key] = implode('', $tile);
                }
            }
//            echo  $fits?'true':'false' . PHP_EOL;
        } while (!$fits);

        foreach ($this->hugeMap as $line) {
            $result += strlen(str_replace(['0'], [''], $line));
        }

        return $result;
    }

    protected function markSeeMonster($monster, $x, $y, $invers)
    {
        $fits = true;
        $yy = $y;
        foreach ($monster as $item) {
            $line = $this->hugeMap[$yy];
            if ((bindec(substr($line, $x, 20)) & $item) !== $item) {
                $fits = false;
                break;
            }
            $yy++;
        }

        if ($fits) {
            $this->found++;
            $yy = $y;
            foreach ($invers as $item) {
                $line = $this->hugeMap[$yy];
                $part = str_pad(decbin(bindec(substr($line, $x, 20)) & $item), 20, '0', STR_PAD_LEFT);
                $newLine = substr($line, 0, $x) . $part . substr($line, $x + 20);
                $this->hugeMap[$yy] = $newLine;
                $yy++;
            }
        }

        return $fits;
    }

    protected function growMap($x, $y)
    {
        $found = $this->findTile($this->map[$y][$x]->getRight(), 'getLeft');
        if ($found) {
            $this->map[$y][$x + 1] = $found;
            unset($this->tiles[$found->getId()]);
            $this->growMap($x + 1, $y);
        }
        $found = $this->findTile($this->map[$y][$x]->getLeft(), 'getRight');
        if ($found) {
            $this->map[$y][$x - 1] = $found;
            unset($this->tiles[$found->getId()]);
            $this->growMap($x - 1, $y);
        }
        $found = $this->findTile($this->map[$y][$x]->getTop(), 'getBottom');
        if ($found) {
            $this->map[$y - 1][$x] = $found;
            unset($this->tiles[$found->getId()]);
            $this->growMap($x, $y - 1);
        }
        $found = $this->findTile($this->map[$y][$x]->getBottom(), 'getTop');
        if ($found) {
            $this->map[$y + 1][$x] = $found;
            unset($this->tiles[$found->getId()]);
            $this->growMap($x, $y + 1);
        }
    }

    /**
     * @param         $pattern
     * @param         $method
     * @param Model[] $this- >tiles
     */
    protected function findTile($pattern, $method)
    {
        foreach ($this->tiles as $tile) {
            if (in_array($pattern, $tile->getEdges())) {
                $rotate = 0;
                $flip = 0;
                do {
                    if ($tile->$method() === $pattern) {
                        return $tile;
                    }
                    if ($rotate < 4) {
                        $tile->rotate();
                        $rotate++;
                    } elseif ($flip === 0) {
                        $tile->flip();
                        $flip++;
                        $rotate = 0;
                    } else {
                        throw new \Exception('Not found match');
                    }
                } while (true);
            }
        }

        return false;
    }
}
