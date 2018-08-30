<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/30
 * Time: 18:29
 */

namespace App\Commands\Http;


use App\App;
use Symfony\Component\Console\Command\Command;
use Workerman\Worker;

abstract class HttpCommand extends Command
{
    public function setWorker($cmd='start')
    {
        global $argv;

        Worker::$pidFile = App::getRuntimePath("/pid")."/http.pid";

        $argv[1] = $cmd;

        Worker::runAll();
    }
}