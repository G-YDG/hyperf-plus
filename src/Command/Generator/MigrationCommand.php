<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Command\Generator;

use Hyperf\Command\Annotation\Command;
use Hyperf\Stringable\Str;
use HyperfPlus\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[Command]
class MigrationCommand extends BaseCommand
{
    public function __construct()
    {
        parent::__construct('plus-gen:migration');
    }

    public function configure()
    {
        $this->setDescription('Create a new migration class');

        parent::configure();
    }

    /**
     * Handle the current command.
     */
    public function handle()
    {
        $this->call('gen:migration', array_filter([
            'name' => $this->input->getArgument('name'),
            '--create' => $this->input->getOption('create'),
            '--table' => $this->input->getOption('table'),
            '--path' => $this->getMigrationPath(),
        ]));

        $this->output->writeln('<info>[INFO] Module generate successfully.</info>');
    }

    /**
     * Get the path to the migration directory.
     */
    protected function getMigrationPath(): string
    {
        return '/app/' . $this->getModuleName() . '/Database/Migrations';
    }

    /**
     * Get module name.
     */
    protected function getModuleName(): string
    {
        return Str::studly(trim($this->input->getOption('module')));
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the migration'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['module', null, InputOption::VALUE_REQUIRED, 'Please enter the module to be generated'],
            ['create', null, InputOption::VALUE_OPTIONAL, 'The table to be created'],
            ['table', null, InputOption::VALUE_OPTIONAL, 'The table to migrate'],
        ];
    }
}
