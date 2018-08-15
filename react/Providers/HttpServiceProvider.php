<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 18:01
 */

namespace ReactApp\Providers;
use App\App;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Http\Response;
use React\Http\Server;
use ReactApp\Annotations\Service;
use ReactApp\Factorys\CreateReactResponse;

/**
 * Class AppServiceProvider
 * @Service("http")
 * @package ReactApp\Providers
 */
class HttpServiceProvider extends ServiceProvider
{
    /** @var LoopInterface */
    private $loop;
    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        $this->loop = Factory::create();

        \Middlewares\Utils\Factory::setResponseFactory(new CreateReactResponse());
    }

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register()
    {
        $server = new Server(function (ServerRequestInterface $request) {
            /** @var DispatcherServiceProvider $dispatcher */
            $dispatcher = App::getService('dispatcher');
            return $dispatcher->dispatch($request);
        });

        $socket = new \React\Socket\Server(8070, $this->loop);
        $server->listen($socket);
    }

    public function run()
    {
        $this->loop->run();
    }
}