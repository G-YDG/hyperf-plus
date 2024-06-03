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
class ServiceCommand extends GeneratorCommand
{
    public function __construct()
    {
        parent::__construct('plus-gen:service');
    }

    public function configure()
    {
        $this->setDescription('Create a new service class');

        parent::configure();
    }

    public function qualifyClass(string $name): string
    {
        return parent::qualifyClass($name) . 'Service';
    }

    public function replaceMapper(string &$stub): static
    {
        $name = $this->getMapperName();
        $stub = str_replace(
            ['%MAPPER%', '%MAPPER_NAME%'],
            [$this->getMapperNamespace($name), $name],
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
            ->replaceMapper($stub)
            ->replaceClass($stub, $name);
    }

    protected function getStub(): string
    {
        return $this->getConfig()['stub'] ?? __DIR__ . '/stubs/service.stub';
    }

    protected function getMapperName(): string
    {
        return Str::studly(trim($this->input->getArgument('name'))) . 'Mapper';
    }

    protected function getMapperNamespace($name): string
    {
        return 'app\\' . $this->getModuleName() . '\\Mapper\\' . $name;
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
        return $this->getConfig()['namespace'] ?? 'App\\' . $this->getModuleName() . '\\Service';
    }
}
