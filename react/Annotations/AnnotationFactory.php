<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 18:07
 */

namespace ReactApp\Annotations;

use App\App;
use Doctrine\Common\Annotations\AnnotationReader;
use ReactApp\Helper\DirectoryHelper;
use ReactApp\Providers\ServiceProviderInterface;
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
                        if( isset($serviceAnnotations[$annotation->name]) ) continue;
                        $annotation->className = $class;
                        $serviceAnnotations[$annotation->name] = $annotation;
                    }
                }
            }
        }

        foreach (App::$before as $i=>$name){
            $annotation = $serviceAnnotations[$name];
            $annotation->sort = 90000+$i;
        }

        foreach ($serviceAnnotations as $name=>$annotation){
            $serviceAnnotations[($annotation->sort+10000).$name] = $annotation;
            unset($serviceAnnotations[$name]);
        }

        ksort($serviceAnnotations);

        foreach ($serviceAnnotations as $annotation){
            $class  = $annotation->className;
            $object = new $class();
            $object->boot();
            App::setService($annotation->name,$object);
        }

        foreach ($serviceAnnotations as $annotation){
            App::getService($annotation->name)->register();
        }
        unset($serviceAnnotations);
    }
}