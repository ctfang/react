<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 18:07
 */

namespace ReactApp\Annotations;

use App\App;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use ReactApp\Helper\DirectoryHelper;
use ReactApp\Providers\ServiceProvider;
use ReactApp\ReactApp;
use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationRegistry;

class AnnotationFactory
{
    /** @var array */
    public static $serviceAnnotations = [];
    /** @var array  */
    public static $requestMappingAnnotations = [];

    /**
     * 初始化
     * @param $namespaces
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public static function init($namespaces)
    {
        $loader    = App::getLoader();
        $directory = new DirectoryHelper();
        $directory->setLoader($loader);
        $directory->setScanNamespace($namespaces);

        AnnotationRegistry::registerLoader(array($loader, "loadClass"));

        self::scanAnnotation($directory);
    }

    /**
     * 索引所有注解
     * @param DirectoryHelper $directory
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public static function scanAnnotation(DirectoryHelper $directory)
    {
        $reader             = new AnnotationReader();

        $serviceAnnotations = [];
        foreach ($directory->scanClass() as $class) {
            if (class_exists($class)) {
                $reflectionClass  = new ReflectionClass($class);
                $classAnnotations = $reader->getClassAnnotations($reflectionClass);

                foreach ($classAnnotations AS $annotation) {
                    if ($annotation instanceof Service) {
                        /** @var ServiceProvider $object */
                        $object = new $class();
                        $object->boot();
                        $serviceAnnotations[] = $annotation->name;
                        App::setService($annotation->name,$object);
                    }
                }
            }
        }
        foreach ($serviceAnnotations as $name){
            App::getService($name)->register();
        }
    }
}