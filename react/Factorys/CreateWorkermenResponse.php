<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/18
 * Time: 14:34
 */

namespace ReactApp\Factorys;


use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use React\Http\Response;

class CreateWorkermenResponse implements ResponseFactoryInterface
{
    /**
     * Create a new response.
     *
     * @param integer $code HTTP status code
     *
     * @return ResponseInterface
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return new Response($code);
    }
}