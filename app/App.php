<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 11:19
 */

namespace App;


use ReactApp\ReactApp;

class App extends ReactApp
{
    public static function isLinux()
    {
        return strstr(PHP_OS, 'WIN') ? false :true;
    }
}