<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/25
 * Time: 11:23
 */

use App\App;

require __DIR__."/bin/define.php";
require __DIR__."/bin/bootstrap.php";


if( App::isLinux() ){

    echo "\n这个文件应该由PHPSTORM启动并运行\n";

    echo "设置PHPSTORM；加入RUN/DEBUG，选择PHP Script\n";

    echo "file:debug.php；Arguments:ws:debug\n\n";

    exit(0);
}

/** @var \ReactApp\Providers\ConsoleServiceProvider $application */
$application = App::getService('console');
$application->run();