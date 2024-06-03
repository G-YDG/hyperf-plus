<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;
use ReflectionClass;

/**
 * 依赖代理注解，用于平替某个类.
 */
#[Attribute(Attribute::TARGET_CLASS)]
class DependProxy extends AbstractAnnotation
{
    public function __construct(public array $values = [], public ?string $provider = null)
    {
    }

    public function collectClass(string $className): void
    {
        if (! $this->provider) {
            $this->provider = $className;
        }
        if (count($this->values) == 0 && class_exists($className)) {
            $reflectionClass = new ReflectionClass(make($className));
            $this->values = array_keys($reflectionClass->getInterfaces());
        }
        parent::collectClass($className);
        DependProxyCollector::setAround($className, $this);
    }
}
