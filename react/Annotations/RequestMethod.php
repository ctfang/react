<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 20:21
 */

namespace ReactApp\Annotations;


class RequestMethod
{
    /**
     * Get method
     */
    const GET = 'GET';

    /**
     * Post method
     */
    const POST = 'POST';

    /**
     * Put method
     */
    const PUT = 'put';

    /**
     * Delete method
     */
    const DELETE = 'delete';

    /**
     * Patch method
     */
    const PATCH = 'patch';

    /**
     * Options method
     */
    const OPTIONS = 'OPTIONS';
}