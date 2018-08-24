<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 15:04
 */

use App\App;
use ReactApp\Annotations\AnnotationFactory;

$loader = require __DIR__.'/../vendor/autoload.php';
require '../react/Helper/Functions.php';
App::setLoader($loader);
/** 注释初始化 */
AnnotationFactory::init(['App\\Providers\\', 'ReactApp\\Providers\\']);
/** @var \ReactApp\Providers\LoopServiceProvider $loop */
$loop = App::getService("loop");
$loop->run();