<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/16
 * Time: 15:41
 */

namespace ReactApp\Factorys;


use Psr\Http\Message\ServerRequestInterface;
use React\Http\Io\ServerRequest;

class CreateWorkermenRequest
{
    public static function create(array $date):ServerRequestInterface
    {
        $request = new ServerRequest(
            $date["server"]["REQUEST_METHOD"]??"GET",
            $date["server"]["REQUEST_URI"]??"/",
            $date["server"]??[],
            $GLOBALS['HTTP_RAW_REQUEST_DATA']??null,
            $date["server"]["SERVER_PROTOCOL"]??"HTTP/1.1",
            $date["server"]??[]
        );

        // Add query params
        $request = $request->withQueryParams($date['get']);
        $request = $request->withParsedBody($date['post']);
        $request = $request->withUploadedFiles($date['files']);

        return $request;
    }
}