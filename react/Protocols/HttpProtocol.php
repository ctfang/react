<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/16
 * Time: 15:04
 */

namespace ReactApp\Protocols;


use App\App;
use Psr\Http\Message\ResponseInterface;
use ReactApp\Factorys\CreateWorkermenRequest;
use ReactApp\Providers\DispatcherServiceProvider;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class HttpProtocol extends Worker
{
    /**
     * Construct.
     *
     * @param string $socket_name
     * @param array  $context_option
     */
    public function __construct($socket_name, $context_option = array())
    {
        list(, $address) = explode(':', $socket_name, 2);
        parent::__construct('http:' . $address, $context_option);
        $this->name = 'HttpServer';
    }

    public function onMessage(TcpConnection $connection, $data)
    {
        $factory = new CreateWorkermenRequest();

        $request = $factory->create($data);

        /** @var DispatcherServiceProvider $dispatcher */
        $dispatcher = App::getService('dispatcher');
        /** @var ResponseInterface $response */
        $response   = $dispatcher->dispatch($request);

        $connection->send($response->getBody()->getContents());
    }
}