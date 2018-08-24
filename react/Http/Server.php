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
use Psr\Http\Message\ServerRequestInterface;
use ReactApp\Factorys\CreateWorkermenRequest;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http;
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

            $this->handleResponse($connection,$response);
        };

        $socket->listen();
    }

    /**
     * @param TcpConnection $connection
     * @param ResponseInterface $response
     */
    public function handleResponse(TcpConnection $connection, ResponseInterface $response)
    {
        $body = $response->getBody();
        
        $headers = $response->getHeaders();

        foreach ($headers as $key=>$value){
            Http::header($key.":".implode(";",$value));
        }

        $code = $response->getStatusCode();

        Http::header('Http-Code:',false,$code);

        $connection->send($body);
    }
}