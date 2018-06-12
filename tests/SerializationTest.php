<?php

namespace SchoolIT\IdpExchange\Tests;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use SchoolIT\IdpExchange\Request\Builder\UpdatedUsersRequestBuilder;
use SchoolIT\IdpExchange\Request\Builder\UserRequestBuilder;
use SchoolIT\IdpExchange\Request\Builder\UsersRequestBuilder;
use SchoolIT\IdpExchange\Request\UsersRequest;
use SchoolIT\IdpExchange\Response\Builder\UserResponseBuilder;
use SchoolIT\IdpExchange\Response\Builder\UpdatedUsersResponseBuilder;
use SchoolIT\IdpExchange\Response\Builder\UsersResponseBuilder;
use SchoolIT\IdpExchange\Response\UsersResponse;

class SerializationTest extends TestCase {
    private function serialize($data) {
        $context = (new SerializationContext())
            ->setSerializeNull(true);

        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($data, 'json', $context);
    }

    public function testUserRequest() {
        $request = (new UserRequestBuilder())
            ->setUsername('foo')
            ->build();

        $json = $this->serialize($request);
        $expextedJson = <<<JSON
{
    "username": "foo"
}
JSON;

        $this->assertJsonStringEqualsJsonString($expextedJson, $json);
    }

    public function testUpdatedUserRequest() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUser('foo')
            ->addUser('bla')
            ->build();

        $json = $this->serialize($request);
        $expextedJson = <<<JSON
{
    "users": [ "foo", "bla" ],
    "since": null
}
JSON;

        $this->assertJsonStringEqualsJsonString($expextedJson, $json);
    }

    public function testUpdatedUserRequestWithSince() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUser('foo')
            ->addUser('bla')
            ->since(new \DateTime('2018-01-01 01:00:00 +0100'))
            ->build();

        $json = $this->serialize($request);
        $expextedJson = <<<JSON
{
    "users": [ "foo", "bla" ],
    "since": "2018-01-01T01:00:00+0100"
}
JSON;

        $this->assertJsonStringEqualsJsonString($expextedJson, $json);
    }

    public function testUsersRequest() {
        $request = (new UsersRequestBuilder())
            ->addUser('foo')
            ->addUser('bla')
            ->build();
        $json = $this->serialize($request);
        $expectedJson = <<<JSON
{
    "users": [ "foo", "bla" ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }

    public function testUserResponse() {
        $response = (new UserResponseBuilder())
            ->setUsername('foo')
            ->addValueAttribute('attribute1', 'value1')
            ->addValuesAttribute('attribute2', [ 'value2', 'value3'])
            ->build();

        $json = $this->serialize($response);
        $expectedJson = <<<JSON
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

        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }

    public function testUsersResponse() {
        $response = (new UsersResponseBuilder())
            ->addUser(
                (new UserResponseBuilder())
                    ->setUsername('foo')
                    ->addValueAttribute('attribute1', 'value1')
                    ->build()
            )
            ->addUser(
                (new UserResponseBuilder())
                    ->setUsername('bla')
                    ->addValueAttribute('attribute1', 'value2')
                    ->build()
            )
            ->build();
        $json = $this->serialize($response);
        $expectedJson = <<<JSON
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

        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

    }

    public function testUpdatedUsersResponse() {
        $response = (new UpdatedUsersResponseBuilder())
            ->addUser('user1', new \DateTime('2018-01-01 00:00:00 +0100'))
            ->addUser('user2', new \DateTime('2018-01-01 00:01:00 +0100'))
            ->build();

        $json = $this->serialize($response);
        $expectedJson = <<<JSON
{
    "users": [
        {
            "username": "user1",
            "updated": "2018-01-01T00:00:00+0100"
        },
        {
            "username": "user2",
            "updated": "2018-01-01T00:01:00+0100"
        }   
    ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }
}