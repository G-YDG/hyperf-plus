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
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Stringable\Str;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[Command]
class TemplateCommand extends HyperfCommand
{
    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('plus-gen:tpl');
    }

    public function configure()
    {
        $this->setDescription('Create a template code for the table');

        parent::configure();
    }

    public function handle()
    {
        $table = $this->input->getArgument('name');

        $this->call('plus-gen:model', array_filter(['table' => $table, '--module' => $this->input->getOption('module'), '--pool' => $this->input->getOption('pool')]));

        $name = Str::studly(trim($this->input->getArgument('name')));

        $this->call('plus-gen:mapper', array_filter(['name' => $name, '--module' => $this->input->getOption('module')]));
        $this->call('plus-gen:service', array_filter(['name' => $name, '--module' => $this->input->getOption('module')]));

        $this->output->writeln('<info>[INFO] Template Code generate successfully.</info>');
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The table name for generate code template.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['module', null, InputOption::VALUE_REQUIRED, 'The module for class.', null],
            ['pool', 'p', InputOption::VALUE_OPTIONAL, 'The database pool for class.', null],
        ];
    }
}
