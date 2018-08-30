<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 16:31
 */

namespace App\WebSocket\Controllers;


use App\Annotations\MessageMapping;

class HelloWorldController
{
    /**
     * @MessageMapping("hello")
     */
    public function index()
    {

    }
}