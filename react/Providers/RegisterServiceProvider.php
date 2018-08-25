<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 17:13
 */

namespace ReactApp\Providers;


use App\App;
use GatewayWorker\Register;
use ReactApp\Annotations\Service;

/**
 * Class RegisterServiceProvider
 * @Service("register")
 * @package ReactApp\Providers
 */
class RegisterServiceProvider implements ServiceProviderInterface
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
        // TODO: Implement boot() method.
    }

    public function listen()
    {
        new Register("text://".App::config('register.socket','0.0.0.0').':'.App::config('register.port'));
    }
}