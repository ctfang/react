<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/14
 * Time: 17:46
 */

namespace ReactApp\Helper;


use Psr\Http\Server\MiddlewareInterface;

class RouteHelper
{
    private $call = [];
    private $middlewares = [];

    public function setClosure($call)
    {
        $this->call = $call;
    }

    public function getClosure()
    {
        return $this->call;
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddleware()
    {
        return $this->middlewares;
    }
}