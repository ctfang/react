<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/30
 * Time: 20:54
 */

namespace App\Commands\WebSocket;


use App\App;
use Symfony\Component\Console\Command\Command;
use Workerman\Worker;

class WebSocketCommand extends Command
{
    public function setWorker($cmd='start')
    {
        global $argv;

        Worker::$pidFile = App::getRuntimePath("/pid")."/ws.pid";

        $argv[1] = $cmd;

        Worker::runAll();
    }
}