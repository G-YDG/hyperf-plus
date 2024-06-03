<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus;

use HyperfPlus\Annotation\DependProxyCollector;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
                'collectors' => [
                    DependProxyCollector::class,
                ],
                'ignore_annotations' => [
                    'required',
                ],
            ],
            'commands' => [],
            'listeners' => [],
        ];
    }
}
