<?php

use React\Socket\ConnectionInterface;

use Clue\React\Redis\Server;

use Clue\React\Redis\StreamingClient;

use Clue\React\Redis\Factory;

class FactoryTest extends TestCase
{
    public function setUp()
    {
        $this->loop = new React\EventLoop\StreamSelectLoop();
        $this->factory = new Factory($this->loop);
    }

    public function testPrequisiteServerAcceptsAnyPassword()
    {
        $this->markTestSkipped();
    }

    /**
     * @depends testPrequisiteServerAcceptsAnyPassword
     */
    public function testClientDefaultSuccess()
    {
        $promise = $this->factory->createClient();

        $this->expectPromiseResolve($promise)->then(function (StreamingClient $client) {
            $client->end();
        });

        $this->loop->run();
    }

    /**
     * @depends testPrequisiteServerAcceptsAnyPassword
     */
    public function testClientAuthSelect()
    {
        $promise = $this->factory->createClient('tcp://authenticationpassword@127.0.0.1:6379/0');

        $this->expectPromiseResolve($promise)->then(function (StreamingClient $client) {
            $client->end();
        });

        $this->loop->run();
    }

    /**
     * @depends testPrequisiteServerAcceptsAnyPassword
     */
    public function testClientAuthenticationContainsColons()
    {
        $promise = $this->factory->createClient('tcp://authentication:can:contain:colons@127.0.0.1:6379');

        $this->expectPromiseResolve($promise)->then(function (StreamingClient $client) {
            $client->end();
        });

        $this->loop->run();
    }

    public function testClientUnconnectableAddress()
    {
        $promise = $this->factory->createClient('tcp://127.0.0.1:2');

        $this->expectPromiseReject($promise);

        $this->loop->tick();
    }

    public function testClientInvalidAddress()
    {
        $promise = $this->factory->createClient('http://invalid target');

        $this->expectPromiseReject($promise);
    }
}
