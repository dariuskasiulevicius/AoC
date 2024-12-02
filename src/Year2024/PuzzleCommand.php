<?php

namespace AdventOfCode\Year2024;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PuzzleCommand extends Base
{
    protected static $defaultName = 'AoC-2024:day';

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
                        ['Mem peak (MB)', memory_get_peak_usage(true)/1024/1024],
                        ['Mem usage (MB)', memory_get_usage(true)/1024/1024],
                    ]
                )
                ->render();
        }

        return 0;
    }
}
