<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/14
 * Time: 21:18
 */

namespace App\Middlewares;


use Middlewares\Whoops;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Whoops\Util\SystemFacade;

class WhoopsMiddleware extends Whoops
{
    public function __construct(Run $whoops = null, SystemFacade $system = null)
    {
        $run = new Run();
        $PrettyPageHandler = new PrettyPageHandler();
        $PrettyPageHandler->handleUnconditionally(true);
        $run->pushHandler($PrettyPageHandler);

        parent::__construct($run, $system);
    }
}