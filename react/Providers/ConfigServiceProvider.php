<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/16
 * Time: 16:04
 */

namespace ReactApp\Providers;


use Noodlehaus\AbstractConfig;
use Noodlehaus\Config;
use ReactApp\Annotations\Service;

/**
 * Class ConfigServiceProvider
 * @Service("config")
 * @package ReactApp\Providers
 */
class ConfigServiceProvider extends AbstractConfig implements ServiceProviderInterface
{
    /** @var string */
    private $path;

    private $default = 'config.php';

    public function __construct(array $data = [])
    {
        $this->path    = realpath(__ROOT_PATH__ . '/config');
        $this->default = realpath($this->path . '/' . $this->default);
        parent::__construct($data);
    }

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        foreach (glob($this->path . '/*.php') as $start_file) {
            if (realpath($start_file) == $this->default) {
                break;
            }
            $arr = include $start_file;
            if ($arr) {
                $this->merge($arr);
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

    }

    /**
     * @return array|mixed
     */
    protected function getDefaults()
    {
        if (file_exists($this->default)) {
            return include $this->default;
        }
        return [];
    }
}