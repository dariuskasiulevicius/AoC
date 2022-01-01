<?php

namespace AdventOfCode\Year2015;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Base extends Command
{
    protected string $rootDir = __DIR__;
    protected string $dayDir;
    protected PuzzleResolver $silverObj;
    protected PuzzleResolver $goldObj;

    protected function initDayDir(string $day): void
    {
        $this->dayDir = 'Day' . str_pad($day, 2, '0', STR_PAD_LEFT);
    }

    protected function getDataFileName(string $fileName): string
    {
        if (file_exists($fileName)) {
            return $fileName;
        }
        $file = $this->rootDir . DIRECTORY_SEPARATOR . $this->dayDir . DIRECTORY_SEPARATOR . $fileName;
        if (file_exists($file)) {
            return $file;
        }

        throw new \Exception('File not found ' . $file);
    }

    protected function initObjects(): void
    {
        $silverClassName = 'AdventOfCode\\Year2015\\' . $this->dayDir . '\\SilverPuzzle';
        $this->silverObj = new $silverClassName();

        $goldClassName = 'AdventOfCode\\Year2015\\' . $this->dayDir . '\\GoldPuzzle';
        $this->goldObj = new $goldClassName();
    }
}
