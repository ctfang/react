<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 18:03
 */

namespace ReactApp\Providers;


interface ServiceProviderInterface
{
    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot();

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register();
}