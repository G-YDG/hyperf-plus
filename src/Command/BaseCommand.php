<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Command;

use Hyperf\Command\Command as HyperfCommand;

abstract class BaseCommand extends HyperfCommand
{
    protected function ensureDirectoryAlreadyExist(string $path): string
    {
        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }
        return $path;
    }
}
