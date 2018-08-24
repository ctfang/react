<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/16
 * Time: 16:26
 */

return [
    /**
     * http服务设置
     */
    'http'       => [
        'port'  => env('HTTP_PORT', 8080),
        'count' => env('HTTP_COUNT', 1),
    ],

    /**
     * 全局中间件
     */
    'middleware' => [

    ],

    'register' => [
        'socket' => env('REGISTER_SOCKET', 'text://0.0.0.0:3238'),
    ],

    'business' => [
        'name'       => env('GATEWAY_NAME', 'MyWsApp'),
        'count'      => env('GATEWAY_COUNT', 1),
    ],

    /**
     * WebSocket配置
     */
    'gateway' => [
        'socket'     => env('GATEWAY_SOCKET', 'ws://0.0.0.0:8070'),
        'name'       => env('GATEWAY_NAME', 'ws'),
        'lan_ip'     => env('GATEWAY_LANIP', '127.0.0.1'),
        'start_port' => env('GATEWAY_START_PORT', '2900'),
        'count'      => env('GATEWAY_COUNT', 1),
    ],
];