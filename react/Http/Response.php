<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/18
 * Time: 14:41
 */

namespace ReactApp\Http;

use React\Http\Io\HttpBodyStream;
use React\Stream\ReadableStreamInterface;
use RingCentral\Psr7\Response as Psr7Response;

class Response extends Psr7Response
{
    public function __construct(
        $status = 200,
        array $headers = array(),
        $body = null,
        $version = '1.1',
        $reason = null
    )
    {
        if ($body instanceof ReadableStreamInterface) {
            $body = new HttpBodyStream($body, null);
        }

        parent::__construct(
            $status,
            $headers,
            $body,
            $version,
            $reason
        );
    }
}