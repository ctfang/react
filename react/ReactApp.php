<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 14:54
 */

namespace ReactApp;


use Composer\Autoload\ClassLoader;
use ReactApp\Annotations\AnnotationFactory;
use ReactApp\Providers\ServiceProvider;

class ReactApp
{
    /** @var array 服务列表 */
    private static $service = [];
    /** @var ClassLoader  */
    private static $loader;

    /**
     * 获取服务对象
     *
     * @param $name
     * @return ServiceProvider|null
     */
    public static function getService($name)
    {
        return self::$service[$name]??null;
    }

    /**
     * 设置服务
     *
     * @param string $name
     * @param ServiceProvider $object
     */
    public static function setService(string $name,ServiceProvider $object)
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
}