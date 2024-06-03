<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus;

class Collection extends \Hyperf\Database\Model\Collection
{
    public function toTree(array $data = [], int $parentId = 0, string $id = 'id', string $parentField = 'parent_id', string $children = 'children'): array
    {
        $data = $data ?: $this->toArray();

        if (empty($data)) {
            return [];
        }

        $tree = [];

        foreach ($data as $value) {
            if ($value[$parentField] == $parentId) {
                $child = $this->toTree($data, $value[$id], $id, $parentField, $children);
                if (! empty($child)) {
                    $value[$children] = $child;
                }
                $tree[] = $value;
            }
        }

        unset($data);
        return $tree;
    }
}
