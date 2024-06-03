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
use Hyperf\Devtool\Generator\GeneratorCommand;
use Hyperf\Stringable\Str;
use Symfony\Component\Console\Input\InputOption;

#[Command]
class MapperCommand extends GeneratorCommand
{
    public function __construct()
    {
        parent::__construct('plus-gen:mapper');
    }

    public function configure()
    {
        $this->setDescription('Create a new mapper class');

        parent::configure();
    }

    public function qualifyClass(string $name): string
    {
        return parent::qualifyClass($name) . 'Mapper';
    }

    public function replaceModel(string &$stub): static
    {
        $name = $this->getModelName();

        $stub = str_replace(
            ['%MODEL%', '%MODEL_NAME%'],
            [$this->getModelNamespace($name), $name],
            $stub
        );

        return $this;
    }

    protected function getOptions(): array
    {
        $options = parent::getOptions();
        $options[] = ['module', null, InputOption::VALUE_REQUIRED, 'Please enter the module to be generated'];
        return $options;
    }

    protected function buildClass(string $name): string
    {
        $stub = file_get_contents($this->getStub());

        return $this
            ->replaceNamespace($stub, $name)
            ->replaceModel($stub)
            ->replaceClass($stub, $name);
    }

    protected function getStub(): string
    {
        return $this->getConfig()['stub'] ?? __DIR__ . '/stubs/mapper.stub';
    }

    protected function getModelName(): string
    {
        return Str::studly(trim($this->input->getArgument('name')));
    }

    protected function getModelNamespace($name): string
    {
        return 'app\\' . $this->getModuleName() . '\\Model\\' . $name;
    }

    /**
     * Get module name.
     */
    protected function getModuleName(): string
    {
        return Str::studly(trim($this->input->getOption('module')));
    }

    protected function getDefaultNamespace(): string
    {
        return $this->getConfig()['namespace'] ?? 'App\\' . $this->getModuleName() . '\\Mapper';
    }
}
