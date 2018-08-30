<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/30
 * Time: 18:27
 */

namespace App\Commands\Http;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Worker;

class StopCommand extends HttpCommand
{
    protected function configure()
    {
        $this
            ->setName('http:stop')
            ->setDescription('关闭http')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setWorker('stop');
    }
}