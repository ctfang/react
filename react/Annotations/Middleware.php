<?php

namespace ReactApp\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Middleware annotation
 *
 * @Annotation
 * @Target({"ALL"})
 */
class Middleware
{

    /**
     * @var string
     */
    private $class = '';

    /**
     * Middleware constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->class = $values['value'];
        }
        if (isset($values['class'])) {
            $this->class = $values['class'];
        }
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}
