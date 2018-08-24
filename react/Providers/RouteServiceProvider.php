<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/10
 * Time: 16:06
 */

namespace ReactApp\Providers;

use App\App;
use Doctrine\Common\Annotations\AnnotationReader;
use ReactApp\Annotations\Middleware;
use ReactApp\Annotations\Middlewares;
use ReactApp\Annotations\RequestMapping;
use ReactApp\Annotations\Service;
use ReactApp\Helper\DirectoryHelper;
use ReactApp\Helper\RouteHelper;
use ReflectionClass;

/**
 * Class RouteServiceProvider
 * @Service(name="route")
 * @package ReactApp\Providers
 */
class RouteServiceProvider implements ServiceProviderInterface
{
    protected $namespaces = ["App\\Http\\Controllers\\"];

    private $dispatcher;

    private $routes;

    private $requestMappingAnnotations;

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        $this->dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $route) {
            foreach ($this->scanRoute() as $arr) {
                /** @var RequestMapping $requestMapping */
                $requestMapping = $arr[0];
                /** @var RouteHelper $routeHelper */
                $routeHelper = $arr[1];
                $route->addRoute($requestMapping->getMethod(), $requestMapping->getRoute(), $routeHelper);
            }
        });
    }

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * @return mixed
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    private function scanRoute()
    {
        $loader    = App::getLoader();
        $directory = new DirectoryHelper();
        $directory->setLoader($loader);
        $directory->setScanNamespace($this->namespaces);
        $reader = new AnnotationReader();
        foreach ($directory->scanClass() as $class) {
            if (class_exists($class)) {
                $reflectionClass  = new ReflectionClass($class);
                $classAnnotations = $reader->getClassAnnotations($reflectionClass);

                $prefix = "";
                $queue  = [];
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
                        $key = "{$prefix}/{$class}/{$reflectionMethod->getName()}";

                        if (!isset($this->routes[$key])) {
                            $routeHelper = new RouteHelper();
                            foreach ($queue as $mid) {
                                $routeHelper->addMiddleware(new $mid());
                            }
                            $this->routes[$key] = $routeHelper;
                        } else {
                            /** @var RouteHelper $routeHelper */
                            $routeHelper = $this->routes[$key];
                        }

                        if ($annotation instanceof RequestMapping) {
                            if (!$annotation->getRoute()) {
                                $tem_1          = explode("\\", $class);
                                $controllerName = end($tem_1);
                                $tem_2          = explode('Controller', $controllerName);
                                $className      = reset($tem_2);
                                $className      = strtolower($className);
                                $annotation->setRoute("{$prefix}/{$className}/{$reflectionMethod->getName()}");
                            }
                            $routeHelper->setClosure([new $class(), $reflectionMethod->getName()]);
                            $this->requestMappingAnnotations[$key] = $annotation;
                        } elseif ($annotation instanceof Middleware) {
                            $mid = $annotation->getClass();
                            $routeHelper->addMiddleware(new $mid());
                        } elseif ($annotation instanceof Middlewares) {
                            /** @var Middleware $middleware */
                            foreach ($annotation->getMiddlewares() as $middleware) {
                                $mid = $middleware->getClass();
                                $routeHelper->addMiddleware(new $mid());
                            }
                        }

                        $this->routes[$key] = $routeHelper;
                    }
                }
            }
        }

        foreach ($this->routes as $key => $routeHelper) {
            if (!isset($this->requestMappingAnnotations[$key])) break;
            yield [$this->requestMappingAnnotations[$key], $routeHelper];
        }
    }
}