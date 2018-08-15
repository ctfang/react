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
     * @var \FastRoute\Dispatcher FastRoute dispatcher
     */
    private $router;

    /**
     * @var string Attribute name for handler reference
     */
    private $attribute = 'request-handler';

    public function __construct()
    {
        /** @var RouteServiceProvider $route */
        $route        = App::getService('route');
        $this->router = $route->getDispatcher();
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $this->router->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($route[0] === \FastRoute\Dispatcher::NOT_FOUND) {
            return Factory::createResponse(404);
        }

        if ($route[0] === \FastRoute\Dispatcher::METHOD_NOT_ALLOWED) {
            return Factory::createResponse(405)->withHeader('Allow', implode(', ', $route[1]));
        }

        foreach ($route[2] as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        /** @var RouteHelper $routeHelper */
        $routeHelper = $route[1];
        $request     = $this->setHandler($request, $routeHelper->getClosure());
        $queue       = $routeHelper->getMiddleware();
        $container   = new RequestHandlerContainer();
        $queue[]     = new RequestHandler($container);
        $dispatcher  = new Dispatcher($queue);

        return $dispatcher->dispatch($request);
    }


    /**
     * Set the handler reference on the request.
     *
     * @param ServerRequestInterface $request
     * @param mixed $handler
     * @return ServerRequestInterface
     */
    protected function setHandler(ServerRequestInterface $request, $handler): ServerRequestInterface
    {
        return $request->withAttribute($this->attribute, $handler);
    }
}