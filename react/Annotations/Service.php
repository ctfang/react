<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/9
 * Time: 18:16
 */

namespace ReactApp\Annotations;

/**
 * Class ServiceAnnotation
 * @Annotation
 * @Target("CLASS")
 * @package ReactApp\Annotations
 */
class Service
{
    public $name;
    public $sort = 100;

    public function __construct(array $values)
    {
        $this->name = $values["name"]??$values["value"];
        $this->sort = $values["sort"]??100;
    }
}