<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/15
 * Time: 15:16
 */

namespace ReactApp\Providers;


use App\App;
use React\EventLoop\Factory;
use ReactApp\Annotations\Service;
use Workerman\Worker;

/**
 * Class LoopServiceProvider
 * @Service("loop",sort="20")
 * @package ReactApp\Providers
 */
class LoopServiceProvider implements ServiceProviderInterface
{
    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {}

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register()
    {

    }

    public function run()
    {
        Worker::runAll();
    }
}