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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[Command]
class ModelCommand extends HyperfCommand
{
    public function __construct()
    {
        parent::__construct('plus-gen:model');
    }

    public function configure()
    {
        $this->setDescription('Create a new model class');

        parent::configure();

        $this->addArgument('table', InputArgument::OPTIONAL, 'Which table you want to associated with the Model.');

        $this->addOption('module', null, InputOption::VALUE_REQUIRED, 'Please enter the module to be generated.');
        $this->addOption('pool', 'p', InputOption::VALUE_OPTIONAL, 'Which connection pool you want the Model use.', 'default');
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'The path that you want the Model file to be generated.');
        $this->addOption('force-casts', 'F', InputOption::VALUE_NONE, 'Whether force generate the casts for model.');
        $this->addOption('prefix', 'P', InputOption::VALUE_OPTIONAL, 'What prefix that you want the Model set.');
        $this->addOption('inheritance', 'i', InputOption::VALUE_OPTIONAL, 'The inheritance that you want the Model extends.');
        $this->addOption('uses', 'U', InputOption::VALUE_OPTIONAL, 'The default class uses of the Model.');
        $this->addOption('refresh-fillable', 'R', InputOption::VALUE_NONE, 'Whether generate fillable argument for model.');
        $this->addOption('table-mapping', 'M', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Table mappings for model.');
        $this->addOption('ignore-tables', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Ignore tables for creating models.');
        $this->addOption('with-comments', null, InputOption::VALUE_NONE, 'Whether generate the property comments for model.');
        $this->addOption('with-ide', null, InputOption::VALUE_NONE, 'Whether generate the ide file for model.');
        $this->addOption('visitors', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Custom visitors for ast traverser.');
        $this->addOption('property-case', null, InputOption::VALUE_OPTIONAL, 'Which property case you want use, 0: snake case, 1: camel case.');
    }

    /**
     * Handle the current command.
     */
    public function handle()
    {
        $this->call('gen:model', array_filter([
            'table' => $this->input->getArgument('table'),
            '--path' => $this->getModelPath(),
            '--pool' => $this->input->getOption('pool'),
            '--force-casts' => $this->input->getOption('force-casts'),
            '--prefix' => $this->input->getOption('prefix'),
            '--inheritance' => $this->input->getOption('inheritance'),
            '--uses' => $this->input->getOption('uses'),
            '--refresh-fillable' => $this->input->getOption('refresh-fillable'),
            '--table-mapping' => $this->input->getOption('table-mapping'),
            '--ignore-tables' => $this->input->getOption('ignore-tables'),
            '--with-comments' => $this->input->getOption('with-comments'),
            '--with-ide' => $this->input->getOption('with-ide'),
            '--visitors' => $this->input->getOption('visitors'),
            '--property-case' => $this->input->getOption('property-case'),
        ]));
    }

    protected function getModelPath()
    {
        $path = $this->input->getOption('path');
        if (! empty($path)) {
            return $path;
        }
        return 'app/' . $this->getModuleName() . '/Model';
    }

    /**
     * Get module name.
     */
    protected function getModuleName(): string
    {
        return Str::studly(trim($this->input->getOption('module')));
    }
}
