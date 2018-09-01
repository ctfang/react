<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 14:54
 */

namespace ReactApp;


use Composer\Autoload\ClassLoader;
use ReactApp\Providers\ServiceProviderInterface;

class ReactApp
{
    /** @var array 服务列表 */
    private static $service = [];
    /** @var ClassLoader  */
    private static $loader;
    /** @var array 优先执行，不受注解影响 */
    public static $before = [
        "env",
        "config",
    ];

    /**
     * 获取服务对象
     *
     * @param $name
     * @return ServiceProviderInterface|null
     */
    public static function getService($name)
    {
        return self::$service[$name]??null;
    }

    /**
     * 获取日记目录
     *
     * @param string $dir
     * @return string
     */
    public static function getRuntimePath($dir=''):string
    {
        $logPath = __ROOT_PATH__.'/runtime'.$dir;
        if( !is_dir($logPath) ){
            mkdir($logPath,0755,true);
        }
        return realpath($logPath);
    }

    /**
     * 设置服务
     *
     * @param string $name
     * @param ServiceProviderInterface $object
     */
    public static function setService(string $name,ServiceProviderInterface $object)
    {
        self::$service[$name] =$object;
    }

    /**
     * 设置类加载器
     * @param ClassLoader $loader
     */
    public static function setLoader(ClassLoader $loader)
    {
        self::$loader = $loader;
    }

    /**
     * @return ClassLoader
     */
    public static function getLoader()
    {
        return self::$loader;
    }

    /**
     * @param $key
     * @param null $default
     * @return string|array|null
     */
    public static function config($key,$default=null)
    {
        return self::$service["config"]->get($key,$default);
    }
}