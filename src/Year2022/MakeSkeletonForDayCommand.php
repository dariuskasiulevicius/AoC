<?php

namespace AdventOfCode\Year2022;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class MakeSkeletonForDayCommand extends Command
{
    protected static $defaultName = 'AoC-2022:make';
    protected string $rootDir = __DIR__;

    protected function configure(): void
    {
        $this
            ->setDescription('Command that creates boilerplate code for selected day')
            ->addArgument('day', InputArgument::REQUIRED, 'Day number. Examples: <5>, <27>.')
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'Remove/delete all data on selected day directory before creating from template'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');
        $dayDir = 'Day' . str_pad($day, 2, '0', STR_PAD_LEFT);
        $dayFullDir = $this->rootDir . DIRECTORY_SEPARATOR . $dayDir;

        // delete existing directory with content in it
        if ($input->getOption('force') && file_exists($dayFullDir) && is_dir($dayFullDir)) {
            $this->deleteDir($dayFullDir);
        }

        if (file_exists($dayFullDir) && is_dir($dayFullDir)) {
            $output->writeln(
                [
                    sprintf('<error>Directory<comment> %s </comment>already exists!</error>', $dayFullDir),
                    '<info>Command terminated.</info>',
                ]
            );

            return 0;
        }

        if (!mkdir($dayFullDir, 0777, true) && !is_dir($dayFullDir)) {
            $output->writeln(
                [
                    sprintf('<error>Can\'t create directory<comment> %s </comment>!</error>', $dayFullDir),
                    '<info>Command terminated.</info>',
                ]
            );

            return 0;
        }

        $this->createFilesFromTemplate($dayDir, $dayFullDir);

        return 0;
    }

    private function deleteDir(string $dir): void
    {
        $finder = new Finder();
        $finder->files()->in($dir);
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    private function createFilesFromTemplate(string $dayDir, string $dayFullDir)
    {
        $finder = new Finder();
        $finder->files()->in($this->rootDir . DIRECTORY_SEPARATOR . 'Template');
        $namespace = 'AdventOfCode\\Year2022\\' . $dayDir;
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $content = $file->getContents();
                if ('php' === $file->getExtension()) {
                    $content = str_replace('{{{namespace}}}', $namespace, $content);
                }
                file_put_contents($dayFullDir . DIRECTORY_SEPARATOR . $file->getFilename(), $content);
            }
        }
    }
}
