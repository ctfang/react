<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/10
 * Time: 17:40
 */

namespace ReactApp\Providers;


use Dotenv\Dotenv;
use ReactApp\Annotations\Service;

/**
 * Class EnvServiceProvider
 * @Service("env",sort="1")
 * @package ReactApp\Providers
 */
class EnvServiceProvider implements ServiceProviderInterface
{
    /**
     * @return void
     */
    public function __construct()
    {
        if (!file_exists(__ROOT_PATH__ . '/.env')) {
            if (!file_exists(__ROOT_PATH__ . '/.env.example')) {
                file_put_contents(__ROOT_PATH__ . '/.env', '');
            } else {
                copy(__ROOT_PATH__ . '/.env.example', __ROOT_PATH__ . '/.env');
            }
        }
        (new Dotenv(__ROOT_PATH__))->load();

        if (isset($_ENV)) {
            foreach ($_ENV as $key => $value) {
                switch (strtolower($value)) {
                    case 'true':
                    case '(true)':
                        $value = true;
                        break;
                    case 'false':
                    case '(false)':
                        $value = false;
                        break;
                    case 'empty':
                    case '(empty)':
                        $value = '';
                        break;
                    case 'null':
                    case '(null)':
                        $value = null;
                        break;
                    default:
                        if( ($strLen = strlen($value)) > 1 && $value{0}==='"' && $value{$strLen}==='"' ){
                            $value = substr($value,1,$strLen-1);
                        }
                        break;
                }
                $_ENV[$key] = $value;
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
        // TODO: Implement register() method.
    }

    /**
     * 加载过程触发
     *
     * @return void
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}