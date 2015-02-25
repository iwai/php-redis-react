<?php
/**
 * PersistentConnector.php
 *
 *
 */


namespace Clue\React\Redis;


use React\Dns\Resolver\Resolver;
use React\EventLoop\LoopInterface;
use React\SocketClient\Connector;

class PersistentConnector extends Connector {

    private $loop;

    public function __construct(LoopInterface $loop, Resolver $resolver)
    {
        $this->loop = $loop;

        parent::__construct($loop, $resolver);
    }

    public function handleConnectedSocket($socket)
    {
        return new PersistentStream($socket, $this->loop);
    }

}
