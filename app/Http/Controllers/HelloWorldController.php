<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 16:30
 */

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use React\Http\Response;
use ReactApp\Annotations\RequestMapping;
use Workerman\Connection\AsyncTcpConnection;

class HelloWorldController
{
    /**
     * 全局路由
     * @RequestMapping("/")
     * @param ServerRequestInterface $request
     * @return array
     */
    public function helloWorld(ServerRequestInterface $request)
    {
        return ['time' => time(), 'query' => $request->getQueryParams(), 'parsed' => $request->getParsedBody()];
    }

    /**
     * 错误显示
     * @RequestMapping("/error")CallableHandler
     */
    public function index()
    {
        throw new \Exception("错误界面显示");
    }

    /**
     * 谷歌镜像
     * @RequestMapping("/google")
     * @param ServerRequestInterface $request
     * @throws \Exception
     */
    public function google(ServerRequestInterface $request)
    {
        $google = "www.baidu.com";

        $conToGoogle = new AsyncTcpConnection("tcp://{$google}:443");
        $conToGoogle->transport = 'ssl';
        $conToGoogle->onConnect = function ($conToGoogle)use($google) {
            $conToGoogle->send("GET / HTTP/1.1\r\nHost: {$google}\r\nConnection: keep-alive\r\n\r\n");
        };
        $conToGoogle->onMessage = function ($conToGoogle, $http_buffer) use ($request) {
            $connection = $request->getAttribute('connection');
            $connection->send($http_buffer,true);
        };
        $conToGoogle->connect();
    }
}