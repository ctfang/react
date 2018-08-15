<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/13
 * Time: 10:55
 */

namespace App\Controllers;

use App\Middlewares\LoginMiddleware;
use App\Middlewares\CorsMiddleware;
use Aura\Session\Session;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReactApp\Annotations\Middleware;
use ReactApp\Annotations\Middlewares;
use ReactApp\Annotations\RequestMapping;

/**
 * Class LoginController
 * @Middlewares({
 *     @Middleware(CorsMiddleware::class)
 * })
 * @package App\Controllers
 */
class LoginController
{
    /**
     * @RequestMapping()
     * @Middleware(LoginMiddleware::class)
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return string
     */
    public function index(ServerRequestInterface $request,RequestHandlerInterface $handler)
    {
        /** @var Session $session */
        $session = $request->getAttribute('session');
        echo 'OK----';
        $response = $handler->handle($request);

        return $response;
    }
}