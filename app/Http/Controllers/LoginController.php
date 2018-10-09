<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/10/9
 * Time: 21:08
 */

namespace App\Http\Controllers;


use Psr\Http\Message\ServerRequestInterface;
use ReactApp\Annotations\RequestMapping;

class LoginController
{
    /**
     * 登陆接口
     * @RequestMapping("/login")
     * @param ServerRequestInterface $request
     * @return array
     */
    public function index(ServerRequestInterface $request)
    {
        return [$request->getQueryParams(),$request->getParsedBody()];
    }
}