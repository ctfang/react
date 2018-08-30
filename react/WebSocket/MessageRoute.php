<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/26
 * Time: 15:34
 */

namespace ReactApp\WebSocket;


class MessageRoute
{
    private $call = [];
    private $route = '';
    private $middleware = [];

    public function setClosure($call)
    {
        $this->call = $call;
    }

    public function getClosure()
    {
        return $this->call;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middleware[] = $middleware;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }
}