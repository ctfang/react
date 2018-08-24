<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/14
 * Time: 15:05
 */

namespace App\Controllers;


use ReactApp\Annotations\RequestMapping;

class HelloWorldController
{
    /**
     * 全局路由
     * @RequestMapping("/")
     */
    public function helloWorld()
    {
        return "helloWorld";
    }

    /**
     * 全局路由
     * @RequestMapping("/error")
     */
    public function index()
    {
        throw new \Exception("错误界面显示");
    }
}