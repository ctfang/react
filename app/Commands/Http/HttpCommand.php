<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/30
 * Time: 18:29
 */

namespace App\Commands\Http;


use Symfony\Component\Console\Command\Command;
use Workerman\Worker;

class HttpCommand extends Command
{
    public function setWorker($cmd='start')
    {
        global $argv;

        $argv[0] = $argv[0].'http';
        $argv[1] = $cmd;

        Worker::runAll();
    }
}