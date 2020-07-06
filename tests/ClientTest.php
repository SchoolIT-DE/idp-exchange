<?php

namespace SchulIT\IdpExchange\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use SchulIT\IdpExchange\Client;
use SchulIT\IdpExchange\Response\UpdatedUsersResponse;
use SchulIT\IdpExchange\Response\UserResponse;
use SchulIT\IdpExchange\Response\UsersResponse;

class ClientTest extends TestCase {

    public function testGetUserSuccess() {
        $json = <<<JSON
{
    "username": "foo",
    "attributes": [
        {
            "name": "attribute1",
            "type": "single",
            "value": "value1"
        },
        {
            "name": "attribute2",
            "type": "multiple",
            "values": [ "value2", "value3" ]
        }
    ]
}
JSON;


        $mock = new MockHandler([
            new Response(200, [], $json)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $response = $client->getUser('foo');

        $this->assertInstanceOf(UserResponse::class, $response);
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     */
    public function testGetUserError() {
        $mock = new MockHandler([
            new RequestException('Error communicating with Server', new Request('GET', '/error'))
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUser('foo');
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     */
    public function testGetUserServerError() {
        $mock = new MockHandler([
            new Response(500)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUser('foo');
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     * @expectedExceptionMessage Request failed with response code 204
     */
    public function testGetUserEmptyResponse() {
        $mock = new MockHandler([
            new Response(204)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUser('foo');
    }

    public function testSuccessGetUpdatedUsers() {
        $json = <<<JSON
{
    "users": [ 
        {
            "username": "user1",
            "updated": "2018-01-01T00:00:00+0100"
        }
    ]
}
JSON;

        $mock = new MockHandler([
            new Response(200, [], $json)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $response = $client->getUpdatedUsers(['foo'], new \DateTime());

        $this->assertInstanceOf(UpdatedUsersResponse::class, $response);
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     */
    public function testGetUpdatedUsersError() {
        $mock = new MockHandler([
            new RequestException('Error communicating with Server', new Request('GET', '/error'))
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUpdatedUsers([], new \DateTime());
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     */
    public function testGetUpdatedUsersServerError() {
        $mock = new MockHandler([
            new Response(500)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUpdatedUsers([], new \DateTime());
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     * @expectedExceptionMessage Request failed with response code 204
     */
    public function testGetUpdatedUsersEmptyResponse() {
        $mock = new MockHandler([
            new Response(204)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUpdatedUsers([], new \DateTime());
    }

    public function testSuccessGetUsers() {
        $json = <<<JSON
{
    "users": [
        {
            "username": "foo",
            "attributes": [
                {
                    "name": "attribute1",
                    "type": "single",
                    "value": "value1"   
                }
            ]
        }, 
        {
            "username": "bla",
            "attributes": [
                {
                    "name": "attribute1",
                    "type": "single",
                    "value": "value2"
                }
            ]
        }
    ]
}
JSON;

        $mock = new MockHandler([
            new Response(200, [], $json)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $response = $client->getUsers(['foo']);

        $this->assertInstanceOf(UsersResponse::class, $response);
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     */
    public function testGetUsersError() {
        $mock = new MockHandler([
            new RequestException('Error communicating with Server', new Request('GET', '/error'))
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUsers(['foo']);
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     */
    public function testGetUsersServerError() {
        $mock = new MockHandler([
            new Response(500)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUsers(['foo']);
    }

    /**
     * @expectedException  \SchulIT\IdpExchange\ClientException
     * @expectedExceptionMessage Request failed with response code 204
     */
    public function testGetUsersEmptyResponse() {
        $mock = new MockHandler([
            new Response(204)
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $serializer = SerializerBuilder::create()->build();

        $client = new Client('https://example.tld/', '123456', $guzzle, $serializer);
        $client->getUsers(['foo']);
    }
}