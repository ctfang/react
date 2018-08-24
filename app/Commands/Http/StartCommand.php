<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/9/2
 * Time: 14:35
 */

namespace App\Commands\Http;


use App\App;
use ReactApp\Providers\HttpServiceProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Worker;

class StartCommand extends Command
{
    public $input;
    public $output;

    protected function configure()
    {
        $this
            ->setName('http:start')
            ->setDescription('开启http服务')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var HttpServiceProvider $http */
        $http = App::getService("http");

        $http->listen();

        Worker::runAll();
    }
}