<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Traits;

use Hyperf\Database\Model\Model;

trait SeederTrait
{
    protected function getTableName($model): string
    {
        /*
         * @var Model $model
         */
        return env('DB_PREFIX') . $model::getModel()->getTable();
    }

    protected function buildInsertData($table_name, array $data): array
    {
        $sqlData = [];
        foreach ($data as $datum) {
            foreach ($datum as &$val) {
                if (is_string($val)) {
                    $val = "'" . $val . "'";
                } elseif ($val === null) {
                    $val = 'NULL';
                }
            }
            $sqlData[] = "INSERT INTO `{$table_name}` VALUES (" . implode(',', $datum) . ')';
        }
        return $sqlData;
    }
}
