<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/10
 * Time: 18:05
 */

namespace ReactApp\Middlewares;


use App\App;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use Middlewares\Utils\RequestHandlerContainer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReactApp\Helper\RouteHelper;
use ReactApp\Providers\RouteServiceProvider;

class ResponseFactoryMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        ob_start();
        $level = ob_get_level();

        try {
            $return = call_user_func_array($request->getAttribute("request-handler"), [$request,$handler]);

            if ($return instanceof ResponseInterface) {
                $response = $return;
                $return = '';
            } elseif ( is_array($return) ){
                $response = Factory::createResponse();
                $response = $response->withAddedHeader("Content-Type",["application/json","charset=utf-8"]);
                $return   = json_encode($return);
            }elseif (is_null($return) || is_scalar($return) || (is_object($return) && method_exists($return, '__toString'))) {
                $response = Factory::createResponse();
            } else {
                throw new \UnexpectedValueException(
                    'The value returned must be scalar or an object with __toString method'
                );
            }

            while (ob_get_level() >= $level) {
                $return = ob_get_clean().$return;
            }

            $body = $response->getBody();

            if ($return !== '' && $body->isWritable()) {
                $body->write($return);
            }

            return $response;
        } catch (\Exception $exception) {
            while (ob_get_level() >= $level) {
                ob_end_clean();
            }

            throw $exception;
        }
    }
}