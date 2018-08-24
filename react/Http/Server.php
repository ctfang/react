<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/18
 * Time: 14:08
 */

namespace ReactApp\Http;


use Evenement\EventEmitter;
use Psr\Http\Message\ResponseInterface;
use ReactApp\Factorys\CreateWorkermenRequest;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class Server extends EventEmitter
{
    protected $requestHandler;

    /**
     * @param $requestHandler
     */
    public function __construct($requestHandler)
    {
        if (!is_callable($requestHandler) && !is_array($requestHandler)) {
            throw new \InvalidArgumentException('Invalid request handler given');
        }

        $this->requestHandler = $requestHandler;
    }

    /**
     * @param Worker $socket
     * @throws \Exception
     */
    public function listen(Worker $socket)
    {
        $socket->onMessage = function (TcpConnection $connection, $data) {

            $request  = CreateWorkermenRequest::create($data);
            /** @var ResponseInterface $response */
            $response = ($this->requestHandler)($request);

            $connection->send($response->getBody());
        };

        $socket->listen();
    }
}