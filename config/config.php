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
        'socket' => env('HTTP_SOCKET', 'http://0.0.0.0:8080'),
        'count'  => env('HTTP_COUNT', 1),
    ],

    /**
     * 全局中间件
     */
    'middleware' => [

    ],

    'register' => [
        // 'socket'  => env('REGISTER_SOCKET', '0.0.0.0'),
        'connect' => env('REGISTER_OTHER', '127.0.0.1'),
        'port'    => env('REGISTER_PORT', 8060),
    ],

    'business' => [
        'name'  => env('BUSINESS_NAME', 'MyWsApp'),
        'count' => env('BUSINESS_COUNT', 1),
    ],

    /**
     * WebSocket配置
     */
    'gateway'  => [
        'socket'     => env('GATEWAY_SOCKET', 'WebSocket://0.0.0.0:8070'),
        'name'       => env('GATEWAY_NAME', 'WebSocket'),
        'lan_ip'     => env('GATEWAY_LANIP', '0.0.0.0'),
        'start_port' => env('GATEWAY_START_PORT', '4000'),
        'count'      => env('GATEWAY_COUNT', 1),
    ],
];