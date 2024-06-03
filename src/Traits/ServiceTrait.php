<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Traits;

use Hyperf\DbConnection\Db;
use Hyperf\Tappable\HigherOrderTapProxy;
use HyperfPlus\Abstracts\AbstractMapper;
use HyperfPlus\Model;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait ServiceTrait
{
    /**
     * @var AbstractMapper
     */
    public $mapper;

    /**
     * 获取列表数据.
     */
    public function getList(?array $params = null): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = is_array($params['select']) ? $params['select'] : explode(',', $params['select']);
        }
        return $this->mapper->getList($params);
    }

    /**
     * 获取列表数据（带分页）.
     */
    public function getPageList(?array $params = null): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = is_array($params['select']) ? $params['select'] : explode(',', $params['select']);
        }
        return $this->mapper->getPageList($params);
    }

    /**
     * 获取树列表.
     */
    public function getTreeList(?array $params = null): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = is_array($params['select']) ? $params['select'] : explode(',', $params['select']);
        }
        return $this->mapper->getTreeList($params);
    }

    /**
     * 新增数据.
     */
    public function save(array $data): int
    {
        return $this->mapper->save($data);
    }

    /**
     * 批量新增.
     */
    public function batchSave(array $collects): bool
    {
        return Db::transaction(function () use ($collects) {
            foreach ($collects as $collect) {
                $this->mapper->save($collect);
            }
            return true;
        });
    }

    /**
     * 读取一条数据.
     */
    public function read(int $id, array $column = ['*']): ?Model
    {
        return $this->mapper->read($id, $column);
    }

    /**
     * 获取单个值
     * @return null|HigherOrderTapProxy|mixed|void
     */
    public function value(array $condition, string $columns = 'id')
    {
        return $this->mapper->value($condition, $columns);
    }

    /**
     * 获取单列值
     */
    public function pluck(array $condition, string $columns = 'id'): array
    {
        return $this->mapper->pluck($condition, $columns);
    }

    /**
     * 按条件读取一行数据.
     */
    public function first(array $condition, array $column = ['*']): ?Model
    {
        return $this->mapper->first($condition, $column);
    }

    /**
     * 查询记录是否存在.
     */
    public function exist(array $condition): bool
    {
        return $this->mapper->exist($condition);
    }

    /**
     * 单个或批量软删除数据.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function delete(array $ids): bool
    {
        return ! empty($ids) && $this->mapper->delete($ids);
    }

    /**
     * 更新数据.
     */
    public function update(int $id, array $data): bool
    {
        return $this->mapper->update($id, $data);
    }

    /**
     * 按条件更新数据.
     */
    public function updateByCondition(array $condition, array $data): bool
    {
        return $this->mapper->updateByCondition($condition, $data);
    }

    /**
     * 单个或批量禁用数据.
     */
    public function disable(array $ids, string $field = 'status'): bool
    {
        return ! empty($ids) && $this->mapper->disable($ids, $field);
    }

    /**
     * 单个或批量启用数据.
     */
    public function enable(array $ids, string $field = 'status'): bool
    {
        return ! empty($ids) && $this->mapper->enable($ids, $field);
    }
}
