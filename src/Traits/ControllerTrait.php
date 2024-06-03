<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Traits;

use HyperfPlus\Request;
use HyperfPlus\Response;
use Psr\Http\Message\ResponseInterface;

trait ControllerTrait
{
    abstract public function getRequest(): Request;

    abstract public function getResponse(): Response;

    public function success(null|array|object|string $msgOrData = '', array|object $data = [], int $code = 200): ResponseInterface
    {
        if (is_string($msgOrData) || is_null($msgOrData)) {
            return $this->getResponse()->success($msgOrData, $data, $code);
        }
        if (is_array($msgOrData) || is_object($msgOrData)) {
            return $this->getResponse()->success(null, $msgOrData, $code);
        }
        return $this->getResponse()->success(null, $data, $code);
    }

    public function error(string $message = '', int $code = 500, mixed $data = []): ResponseInterface
    {
        return $this->getResponse()->error($message, $code, $data);
    }

    public function redirect(string $toUrl, int $status = 302, string $schema = 'http'): ResponseInterface
    {
        return $this->getResponse()->redirect($toUrl, $status, $schema);
    }

    public function _download(string $filePath, string $name = ''): ResponseInterface
    {
        return $this->getResponse()->download($filePath, $name);
    }
}
