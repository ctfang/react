<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 18:30
 */

namespace App\Commands\WebSocket;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Worker;

/**
 * Class StopCommand
 * @package App\Commands\WebSocket
 * @\ReactApp\Annotations\Command()
 */
class StopCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:stop')
            ->setDescription('关闭所有worker')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        global $argv;
        $argv[1] = 'stop';

        Worker::runAll();
    }
}