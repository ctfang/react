<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/26
 * Time: 14:45
 */

namespace App\Annotations;

/**
 * action方法注解
 *
 * @Annotation
 * @Target("METHOD")
 */
class MessageMapping
{
    protected $route;

    public function __construct(array $values)
    {
        $this->route = $values['route']??$values['value']??'';
    }

    public function getRoute()
    {
        return $this->route;
    }
}