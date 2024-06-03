<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Command\Module;

use Hyperf\Command\Annotation\Command;
use Hyperf\Stringable\Str;
use HyperfPlus\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;

#[Command]
class InitCommand extends BaseCommand
{
    public function __construct()
    {
        parent::__construct('plus-module:init');
    }

    /**
     * Handle the current command.
     */
    public function handle()
    {
        $path = $this->ensureDirectoryAlreadyExist($this->getModulePath());

        foreach ($this->getModuleSubDirs() as $subDir) {
            $this->ensureDirectoryAlreadyExist($path . DIRECTORY_SEPARATOR . $subDir);
        }

        $this->info('Init module directory successfully.');
    }

    /**
     * Get module path.
     */
    protected function getModulePath(): string
    {
        return BASE_PATH . '/app/' . $this->getModuleName();
    }

    /**
     * Get module name.
     */
    protected function getModuleName(): string
    {
        return Str::studly(trim($this->input->getArgument('name')));
    }

    protected function getModuleSubDirs(): array
    {
        return [
            'Controller',
            'Database',
            'Dictionary',
            'Mapper',
            'Model',
            'Request',
            'Service',
        ];
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the module'],
        ];
    }
}
