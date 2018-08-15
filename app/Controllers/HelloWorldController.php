<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/14
 * Time: 15:05
 */

namespace App\Controllers;


use ReactApp\Annotations\RequestMapping;

class HelloWorldController
{
    /**
     * @RequestMapping("/")
     */
    public function index()
    {
        tefgg();
    }
}