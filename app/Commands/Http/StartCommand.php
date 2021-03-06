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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Worker;

/**
 * Class StartCommand
 * @package App\Commands\Http
 * @\ReactApp\Annotations\Command()
 */
class StartCommand extends HttpCommand
{
    public $input;
    public $output;

    protected function configure()
    {
        $this
            ->setName('http:start')
            ->addOption(
                "domain",
                null,
                InputOption::VALUE_OPTIONAL,
                "是否守护进程运行",
                0
            )
            ->setDescription('开启http服务')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $domain = $input->getOption("domain");

        if( $domain  || $domain===null ){
            $output->writeln("<info>守护进程启动</info>");

            Worker::$daemonize = true;
        }

        /** @var HttpServiceProvider $http */
        $http = App::getService("http");

        $http->listen();

        $this->setWorker('start');
    }
}