<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/9/2
 * Time: 14:39
 */

namespace ReactApp\Providers;
use App\App;
use Doctrine\Common\Annotations\AnnotationReader;
use ReactApp\Annotations\Service;
use ReactApp\Helper\DirectoryHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

/**
 * Class CommandServiceProvider
 * @Service("console")
 * @package ReactApp\Providers
 */
class ConsoleServiceProvider implements ServiceProviderInterface
{
    /** @var Application */
    protected $application;

    protected $namespaces = ["App\\Commands\\"];

    private $commands = [];

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        $loader    = App::getLoader();
        $directory = new DirectoryHelper();
        $directory->setLoader($loader);
        $directory->setScanNamespace($this->namespaces);

        foreach ($directory->scanClass() as $class) {
            if (class_exists($class)) {
                $this->commands[] = $class;
            }
        }
    }

    /**
     * 所有服务加载后，注册触发，
     *
     * @return void
     */
    public function register()
    {
        $application = new Application("workermen http and ws server","0.1.2");

        foreach ($this->commands as $command){
            $class = new $command();
            if( $class instanceof Command){
                $application->add(new $command());
            }
        }

        $this->application = $application;
        unset($this->commands);
    }

    public function run()
    {
        $this->application->run();
    }
}