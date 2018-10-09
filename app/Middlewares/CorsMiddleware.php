<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/13
 * Time: 10:54
 */

namespace App\Middlewares;


use App\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Middlewares\Utils\Factory;
use ReactApp\Annotations\RequestMethod;

/**
 * 跨域控制
 * @package App\Middlewares
 */
class CorsMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if( $request->getMethod()==RequestMethod::OPTIONS ){
            $response = Factory::createResponse();
            $body     = $response->getBody();
            $body->write('');
            $response = $response->withBody($body);
            $response = $response->withAddedHeader("Access-Control-Allow-Headers","content-type");
        }else{
            $response = $handler->handle($request);
        }
        $response = $response->withAddedHeader('Access-Control-Allow-Origin', "*");
        return $response;
    }
}