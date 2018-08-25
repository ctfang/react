<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/8/25
 * Time: 16:12
 */

namespace ReactApp\Protocols;

use Workerman\Connection\TcpConnection;

use Workerman\Connection\AsyncTcpConnection;
use GatewayWorker\Protocols\GatewayProtocol;


class BusinessWorker extends \GatewayWorker\BusinessWorker
{

    /**
     * 当注册中心发来消息时
     *
     * @return void
     */
    public function onRegisterConnectionMessage($register_connection, $data)
    {
        $data = json_decode($data, true);
        if (!isset($data['event'])) {
            echo "Received bad data from Register\n";
            return;
        }
        $event = $data['event'];
        switch ($event) {
            case 'broadcast_addresses':
                if (!is_array($data['addresses'])) {
                    echo "Received bad data from Register. Addresses empty\n";
                    return;
                }
                $addresses               = $data['addresses'];
                $this->_gatewayAddresses = array();
                foreach ($addresses as $addr) {
                    $this->_gatewayAddresses[$addr] = $addr;
                }
                $this->checkGatewayConnections($addresses);
                break;
            default:
                echo "Receive bad event:$event from Register.\n";
        }
    }


    /**
     * 尝试连接 Gateway 内部通讯地址
     *
     * @param string $addr
     * @throws \Exception
     */
    public function tryToConnectGateway($addr)
    {
        if (!isset($this->gatewayConnections[$addr]) && !isset($this->_connectingGatewayAddresses[$addr]) && isset($this->_gatewayAddresses[$addr])) {

            $conAddr = str_replace('0.0.0.0','127.0.0.1',$addr);

            $gateway_connection                    = new AsyncTcpConnection("GatewayProtocol://$conAddr");
            $gateway_connection->remoteAddress     = $addr;
            $gateway_connection->onConnect         = array($this, 'onConnectGateway');
            $gateway_connection->onMessage         = array($this, 'onGatewayMessage');
            $gateway_connection->onClose           = array($this, 'onGatewayClose');
            $gateway_connection->onError           = array($this, 'onGatewayError');
            $gateway_connection->maxSendBufferSize = $this->sendToGatewayBufferSize;
            if (TcpConnection::$defaultMaxSendBufferSize == $gateway_connection->maxSendBufferSize) {
                $gateway_connection->maxSendBufferSize = 50 * 1024 * 1024;
            }
            $gateway_data         = GatewayProtocol::$empty;
            $gateway_data['cmd']  = GatewayProtocol::CMD_WORKER_CONNECT;
            $gateway_data['body'] = json_encode(array(
                'worker_key' =>"{$this->name}:{$this->id}",
                'secret_key' => $this->secretKey,
            ));
            $gateway_connection->send($gateway_data);
            $gateway_connection->connect();
            $this->_connectingGatewayAddresses[$addr] = $addr;
        }
        unset($this->_waitingConnectGatewayAddresses[$addr]);
    }
}