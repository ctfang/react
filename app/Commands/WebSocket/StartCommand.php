<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/24
 * Time: 15:19
 */

namespace App\Commands\WebSocket;


use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Worker;

class StartCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:start')
            ->addOption(
                "domain",
                null,
                InputOption::VALUE_OPTIONAL,
                "是否守护进程运行",
                0
            )
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_OPTIONAL,
                '是否启用隔离调试',
                0
            )
            ->setDescription('开启WebSocket服务')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $domain = $input->getOption("domain");
        $debug  = $input->getOption("debug");

        if( $domain  || $domain===null ){
            $output->writeln("<info>守护进程启动</info>");

            Worker::$daemonize = true;
        }

        App::getService("register")->listen();
        App::getService("gateway")->listen();

        if( $debug===null || $debug ){
            // 启用隔离
            $output->writeln("<info>开启隔离；需要另外开启ws:debug处理</info>");
        }else{
            App::getService("business")->listen();
        }

        global $argv;
        $argv[1] = 'start';

        Worker::runAll();
    }
}