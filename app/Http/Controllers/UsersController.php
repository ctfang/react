<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 16:30
 */

namespace App\Http\Controllers;

use App\Middlewares\LoginMiddleware;
use App\Middlewares\CorsMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use ReactApp\Annotations\Middleware;
use ReactApp\Annotations\Middlewares;
use ReactApp\Annotations\RequestMapping;

/**
 * @Middlewares({
 *     @Middleware(CorsMiddleware::class)
 * })
 * @package App\Controllers
 */
class UsersController
{
    /**
     * @RequestMapping("/login")
     * @Middleware(LoginMiddleware::class)
     * @param ServerRequestInterface $request
     * @return string
     */
    public function index(ServerRequestInterface $request,$handler)
    {
        echo 'OK----';
    }
}