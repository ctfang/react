<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 18:15
 */

namespace App\Commands\WebSocket;


use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Worker;

class StartDebugCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:debug')
            ->setDescription('开启business服务')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        App::getService("business")->listen();

        global $argv;
        $argv[1] = 'start';

        Worker::runAll();
    }
}