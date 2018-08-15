<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/10
 * Time: 17:54
 */

namespace ReactApp\Providers;
use App\Middlewares\WhoopsMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReactApp\Annotations\Service;
use ReactApp\Middlewares\ResponseFactoryMiddleware;
use Relay\Relay;
use Relay\RequestHandler;

/**
 * Class DispatcherServiceProvider
 * @Service("dispatcher")
 * @package ReactApp\Providers
 */
class DispatcherServiceProvider extends ServiceProvider
{
    /** @var RequestHandler */
    private $relay;

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register()
    {
        $relay = new Relay([
            new WhoopsMiddleware(),
            new ResponseFactoryMiddleware(),
        ]);

        $this->relay = $relay;
    }

    /**
     * 调度处理
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request):ResponseInterface
    {
        return $this->relay->handle($request);
    }
}