<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/10
 * Time: 17:54
 */

namespace ReactApp\Providers;

use App\App;
use App\Middlewares\WhoopsMiddleware;
use FastRoute\Dispatcher;
use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReactApp\Annotations\Service;
use ReactApp\Helper\RouteHelper;
use ReactApp\Middlewares\ResponseFactoryMiddleware;
use Relay\Relay;
use Relay\RequestHandler;
use RingCentral\Psr7\Stream;

/**
 * Class DispatcherServiceProvider
 * @Service("dispatcher")
 * @package ReactApp\Providers
 */
class DispatcherServiceProvider implements ServiceProviderInterface
{
    /** @var array */
    private $defaultMiddleware = [];

    /** @var Dispatcher */
    private $route;

    protected $responseFactory;


    /**
     * @var string Attribute name for handler reference
     */
    private $attribute = 'request-handler';

    protected $responder;

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        $this->responseFactory = new ResponseFactoryMiddleware();
        $this->responder = function ($request, $next) {
            return Factory::createResponse();
        };
    }

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register()
    {
        foreach (App::config('middleware') as $middleware) {
            $this->defaultMiddleware[] = new $middleware();
        }
        /** @var RouteServiceProvider $router */
        $router      = App::getService('route');
        $this->route = $router->getDispatcher();
    }

    /**
     * 调度处理
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $route = $this->route->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($route[0] === Dispatcher::NOT_FOUND) {
            return Factory::createResponse(404);
        }

        foreach ($route[2] as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        /** @var RouteHelper $routeHelper */
        $routeHelper = $route[1];
        $queue       = $this->defaultMiddleware;
        $queue       = array_merge($queue, $routeHelper->getMiddleware());
        $queue[]     = $this->responseFactory;
        $queue[]     = $this->responder;
        $relay       = new Relay($queue);
        $request     = $this->setHandler($request, $routeHelper->getClosure());
        return $relay->handle($request);
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