<?php

namespace AdventOfCode\Year2021;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PuzzleCommand extends Command
{
    protected static $defaultName = 'AoC-2021:day';
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
        $startTime = microtime(true);
        $silver = $this->silverObj->resolve($dataInput);
        $silverTime = microtime(true) - $startTime;
        $output->writeln('Silver time: ' . $silverTime, OutputInterface::VERBOSITY_VERBOSE);

        $startTime = microtime(true);
        $gold = $this->goldObj->resolve($dataInput);
        $goldTime = microtime(true) - $startTime;
        $output->writeln('Gold time: ' . $goldTime, OutputInterface::VERBOSITY_VERBOSE);

        $table
            ->setHeaders(['Star type', 'Result value', 'Execution time (s)'])
            ->setHeaderTitle('Day ' . $day)
            ->setRows(
                [
                    ['Silver', $silver, $silverTime],
                    ['Gold', $gold, $goldTime],
                ]
            )
            ->setStyle('box-double')
            ->render();

        if (OutputInterface::VERBOSITY_VERY_VERBOSE === $output->getVerbosity()) {
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

        throw new \Exception('File not found ' . $file);
    }

    private function initObjects(): void
    {
        $silverClassName = 'AdventOfCode\\Year2021\\' . $this->dayDir . '\\SilverPuzzle';
        $this->silverObj = new $silverClassName();

        $goldClassName = 'AdventOfCode\\Year2021\\' . $this->dayDir . '\\GoldPuzzle';
        $this->goldObj = new $goldClassName();
    }
}
