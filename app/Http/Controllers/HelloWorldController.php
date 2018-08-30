<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 16:30
 */

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use ReactApp\Annotations\RequestMapping;

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
        return ['time'=>time(),'query'=>$request->getQueryParams(),'parsed'=>$request->getParsedBody()];
    }

    /**
     * 错误显示
     * @RequestMapping("/error")CallableHandler
     */
    public function index()
    {
        throw new \Exception("错误界面显示");
    }
}