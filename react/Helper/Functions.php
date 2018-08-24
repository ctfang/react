<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/10
 * Time: 18:10
 */

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}