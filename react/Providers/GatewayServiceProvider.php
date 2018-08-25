<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 17:15
 */

namespace ReactApp\Providers;

use App\App;
use GatewayWorker\Gateway;
use ReactApp\Annotations\Service;

/**
 * Class GatewayServiceProvider
 * @Service("gateway")
 * @package ReactApp\Providers
 */
class GatewayServiceProvider implements ServiceProviderInterface
{

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
        // TODO: Implement register() method.
    }


    public function listen()
    {
        // gateway 进程，这里使用Text协议，可以用telnet测试
        $gateway = new Gateway(App::config('gateway.socket'));
        // gateway名称，status方便查看
        $gateway->name = App::config('gateway.name');
        // gateway进程数
        $gateway->count = App::config('gateway.count', 1);
        // 本机ip，分布式部署时使用内网ip
        $gateway->lanIp = App::config('gateway.lan_ip');
        // 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
        // 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口
        $gateway->startPort = App::config('gateway.start_port');
        // 服务注册地址
        $gateway->registerAddress = App::config('register.connect').':'.App::config('register.port');
    }
}