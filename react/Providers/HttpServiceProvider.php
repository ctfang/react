<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 18:01
 */

namespace ReactApp\Providers;

use App\App;
use Middlewares\Utils\Factory;
use Psr\Http\Message\ServerRequestInterface;
use ReactApp\Annotations\Service;
use ReactApp\Factorys\CreateWorkermenResponse;
use ReactApp\Http\Server;
use Workerman\Worker;

/**
 * Class AppServiceProvider
 * @Service("http")
 * @package ReactApp\Providers
 */
class HttpServiceProvider implements ServiceProviderInterface
{
    protected $socket = "http://0.0.0.0";

    protected $port = 80;

    protected $count = 1;

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        Factory::setResponseFactory(new CreateWorkermenResponse());
    }

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     * @throws \Exception
     */
    public function register()
    {
        $this->port  = App::config('http.port', 8080);
        $this->count = App::config('http.count');
    }

    public function listen()
    {
        $server        = new Server(function (ServerRequestInterface $request) {
            /** @var DispatcherServiceProvider $dispatcher */
            $dispatcher = App::getService('dispatcher');
            return $dispatcher->dispatch($request);
        });
        $socket        = new Worker("http://0.0.0.0:{$this->port}");

        if( App::isLinux() ){
            $socket->count = $this->count;
        }

        $server->listen($socket);
    }
}