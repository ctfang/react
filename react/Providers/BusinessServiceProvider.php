<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 17:18
 */

namespace ReactApp\Providers;
use App\App;
use App\WebSocket\Events\WsEvent;
use ReactApp\Annotations\Service;
use ReactApp\Protocols\BusinessWorker;

/**
 * Class BusinessServiceProvider
 * @Service("business")
 * @package ReactApp\Providers
 */
class BusinessServiceProvider implements ServiceProviderInterface
{
    protected $worker;

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register()
    {

    }

    public function listen()
    {
        // bussinessWorker 进程
        $worker = new BusinessWorker();
        // worker名称
        $worker->name = App::config('business.name', 'business');
        // bussinessWorker进程数量
        $worker->count = App::isLinux() ? App::config('business.count') : 1;
        // 服务注册地址
        $worker->registerAddress = App::config('register.connect').':'.App::config('register.port');
        $worker->eventHandler    = WsEvent::class;
    }
}