<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/26
 * Time: 10:38
 */

namespace ReactApp\WebSocket;


use App\Annotations\MessageMapping;
use App\App;
use Doctrine\Common\Annotations\AnnotationReader;
use ReactApp\Annotations\Middleware;
use ReactApp\Annotations\Middlewares;
use ReactApp\Helper\DirectoryHelper;
use ReflectionClass;
use Workerman\Worker;

class Event
{
    protected static $dispatcher;

    private static $middleware = [];

    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return mixed
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public static function onWorkerStart(Worker $worker)
    {
        $routes = [];

        $directory = self::getDirectoryHelper(["App\\WebSocket\\Controllers\\"]);
        $reader    = new AnnotationReader();
        foreach ($directory->scanClass() as $class) {
            if (class_exists($class)) {
                $reflectionClass  = new ReflectionClass($class);
                $classAnnotations = $reader->getClassAnnotations($reflectionClass);

                $queue = [];
                foreach ($classAnnotations AS $annotation) {
                    if ($annotation instanceof Middleware) {
                        $queue[] = $annotation->getClass();;
                    } elseif ($annotation instanceof Middlewares) {
                        /** @var Middleware $middleware */
                        foreach ($annotation->getMiddlewares() as $middleware) {
                            $queue[] = $middleware->getClass();
                        }
                    }
                }

                foreach ($reflectionClass->getMethods() as $reflectionMethod) {
                    $methodAnnotations = $reader->getMethodAnnotations($reflectionMethod);

                    foreach ($methodAnnotations AS $annotation) {
                        $key = "{$class}/{$reflectionMethod->getName()}";

                        if (!isset($routes[$key])) {
                            $routeHelper = new MessageRoute();
                            foreach ($queue as $mid) {
                                $routeHelper->addMiddleware(self::getMiddleware($mid));
                            }
                            $routes[$key] = $routeHelper;
                        } else {
                            /** @var MessageRoute $routeHelper */
                            $routeHelper = $routes[$key];
                        }

                        if ($annotation instanceof MessageMapping) {
                            $routeHelper->setRoute($annotation->getRoute());
                            $routeHelper->setClosure([new $class(), $reflectionMethod->getName()]);
                        } elseif ($annotation instanceof Middleware) {
                            $mid = $annotation->getClass();
                            $routeHelper->addMiddleware(self::getMiddleware($mid));
                        } elseif ($annotation instanceof Middlewares) {
                            /** @var Middleware $middleware */
                            foreach ($annotation->getMiddlewares() as $middleware) {
                                $mid = $middleware->getClass();
                                $routeHelper->addMiddleware(self::getMiddleware($mid));
                            }
                        }

                        $routes[$key] = $routeHelper;
                    }
                }
            }
        }
        self::$middleware = null;
        return $routes;
    }

    private static function getMiddleware($mid)
    {
        if (!isset(self::$middleware[$mid])) {
            self::$middleware[$mid] = new $mid();
        }
        return self::$middleware[$mid];
    }


    /**
     * 获取目录操作
     *
     * @param array $namespaces 需要搜索的命名空间
     * @return DirectoryHelper
     */
    protected static function getDirectoryHelper(array $namespaces)
    {
        $loader    = App::getLoader();
        $directory = new DirectoryHelper();
        $directory->setLoader($loader);
        $directory->setScanNamespace($namespaces);
        return $directory;
    }
}