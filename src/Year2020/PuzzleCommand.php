<?php

namespace AdventOfCode\Year2020;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PuzzleCommand extends Command
{
    protected static $defaultName = 'AoC-2020:day';
    protected string $rootDir = __DIR__;
    protected string $dayDir;
    protected PuzzleResolver $silverObj;
    protected PuzzleResolver $goldObj;

    protected function configure(): void
    {
        $this
            ->setDescription('Command that runs code for selected day')
            ->addArgument('day', InputArgument::REQUIRED, 'Day number. Examples: <5>, <27>.')
            ->addOption(
                'data',
                'd',
                InputOption::VALUE_REQUIRED,
                'Data input file name with/without full path',
                'Data.txt'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');
        $this->initDayDir($day);
        $this->initObjects();
        $dataFileName = $this->getDataFileName($input->getOption('data'));
        $dataInput = new DataInput($dataFileName);


        $table = new Table($output);
        $table
            ->setHeaders(['Star type', 'Result value'])
            ->setHeaderTitle('Day ' . $day)
            ->setRows(
                [
                    ['Silver', $this->silverObj->resolve($dataInput)],
                    ['Gold', $this->goldObj->resolve($dataInput)],
                ]
            )
            ->setStyle('box-double')
            ->render();

        if (OutputInterface::VERBOSITY_VERBOSE === $output->getVerbosity()) {
            $table = new Table($output);
            $table
                ->setHeaders(['Information description', 'Value'])
                ->setHeaderTitle('Debug information')
                ->setRows(
                    [
                        ['Root dir', $this->rootDir],
                        ['Day dir', $this->dayDir],
                        ['Data file', $dataFileName],
                        ['Silver class name', get_class($this->silverObj)],
                        ['Gold class name', get_class($this->goldObj)],
                    ]
                )
                ->render();
        }

        return 0;
    }

    private function initDayDir(string $day): void
    {
        $this->dayDir = 'Day' . str_pad($day, 2, '0', STR_PAD_LEFT);
    }

    private function getDataFileName(string $fileName): string
    {
        if (file_exists($fileName)) {
            return $fileName;
        }
        $file = $this->rootDir . DIRECTORY_SEPARATOR . $this->dayDir . DIRECTORY_SEPARATOR . $fileName;
        if (file_exists($file)) {
            return $file;
        }

        throw new \Exception('File not found ' . $fileName);
    }

    private function initObjects(): void
    {
        $silverClassName = 'AdventOfCode\\Year2020\\' . $this->dayDir . '\\SilverPuzzle';
        $this->silverObj = new $silverClassName();

        $goldClassName = 'AdventOfCode\\Year2020\\' . $this->dayDir . '\\GoldPuzzle';
        $this->goldObj = new $goldClassName();
    }
}
