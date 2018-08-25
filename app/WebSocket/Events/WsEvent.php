<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 19:25
 */

namespace App\WebSocket\Events;

use GatewayWorker\Lib\Gateway;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class WsEvent
{
    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return mixed
     */
    public static function onWorkerStart(Worker $worker)
    {

    }


    /**
     * 连接事件
     *
     * @param TcpConnection $connection
     * @return mixed
     */
    public static function onConnect(TcpConnection $connection)
    {

    }

    /**
     * 接收信息
     *
     * @param TcpConnection $connection
     * @param string|array $message
     * @return mixed
     */
    public static function onMessage(TcpConnection $connection, $message)
    {

    }

    /**
     * 客户端断开触发
     *
     * @param TcpConnection $connection
     * @return mixed
     */
    public static function onClose(TcpConnection $connection)
    {

    }
}