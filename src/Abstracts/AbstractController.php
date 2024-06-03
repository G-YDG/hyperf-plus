<?php

declare(strict_types=1);
/**
 * This file is part of HyperfPlus.
 *
 * @link     https://github.com/G-YDG/hyperf-plus
 * @license  https://github.com/G-YDG/hyperf-plus/blob/master/LICENSE
 */

namespace HyperfPlus\Abstracts;

use Hyperf\Di\Annotation\Inject;
use HyperfPlus\Request;
use HyperfPlus\Response;
use HyperfPlus\Traits\ControllerTrait;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    use ControllerTrait;

    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected Request $request;

    #[Inject]
    protected Response $response;

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
