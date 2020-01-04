<?php

namespace SchoolIT\IdpExchange\Tests;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use SchoolIT\IdpExchange\Request\UpdatedUsersRequest;
use SchoolIT\IdpExchange\Request\UserRequest;
use SchoolIT\IdpExchange\Request\UsersRequest;
use SchoolIT\IdpExchange\Response\UpdatedUsersResponse;
use SchoolIT\IdpExchange\Response\UserResponse;
use SchoolIT\IdpExchange\Response\UsersResponse;
use SchoolIT\IdpExchange\Response\UserUpdateInformation;
use SchoolIT\IdpExchange\Response\ValueAttribute;
use SchoolIT\IdpExchange\Response\ValuesAttribute;

class DeserializationTest extends TestCase {
    private function deserialize($json, $type) {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->deserialize($json, $type, 'json');
    }

    public function testDeserializeUserRequest() {
        $json = <<<JSON
{
    "username": "foo"
}
JSON;
        $request = $this->deserialize($json, UserRequest::class);

        $this->assertInstanceOf(UserRequest::class, $request);
        $this->assertEquals('foo', $request->username);
    }

    public function testDeserializeUpdatedUsersRequest() {
        $json = <<<JSON
{
    "usernames": [ "user1", "user2" ]
}
JSON;

        $request = $this->deserialize($json, UpdatedUsersRequest::class);

        $this->assertInstanceOf(UpdatedUsersRequest::class, $request);
        $this->assertEquals(['user1', 'user2'], $request->usernames);
        $this->assertNull($request->since);
    }

    public function testDeserializeUpdatedUsersRequestWithSince() {
        $json = <<<JSON
{
    "usernames": [ "user1", "user2" ],
    "since": "2018-01-01T01:00:00+01:00"
}
JSON;

        $request = $this->deserialize($json, UpdatedUsersRequest::class);

        $this->assertInstanceOf(UpdatedUsersRequest::class, $request);
        $this->assertEquals(['user1', 'user2'], $request->usernames);
        $this->assertNotNull($request->since);
        $this->assertInstanceOf(\DateTime::class, $request->since);
        $this->assertEquals(new \DateTime('2018-01-01 01:00:00 +01:00'), $request->since);
    }

    public function testDeserializeUsersRequest() {
        $json = <<<JSON
{
    "usernames": [ "user1", "user2" ]
}
JSON;

        $request = $this->deserialize($json, UsersRequest::class);

        $this->assertInstanceOf(UsersRequest::class, $request);
        $this->assertEquals(['user1', 'user2'], $request->usernames);
    }

    public function testDeserializeUserResponse() {
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
        },
        {
            "name": "attribute3",
            "type": "single",
            "value": null
        }
    ]
}
JSON;

        $response = $this->deserialize($json, UserResponse::class);

        $this->assertInstanceOf(UserResponse::class, $response);
        $this->assertEquals('foo', $response->username);
        $this->assertEquals(3, count($response->attributes));
        $this->assertInstanceOf(ValueAttribute::class, $response->attributes[0]);
        $this->assertEquals('attribute1', $response->attributes[0]->name);
        $this->assertEquals('value1', $response->attributes[0]->value);
        $this->assertInstanceOf(ValuesAttribute::class, $response->attributes[1]);
        $this->assertEquals('attribute2', $response->attributes[1]->name);
        $this->assertEquals(['value2', 'value3'], $response->attributes[1]->values);
        $this->assertEquals('attribute3', $response->attributes[2]->name);
        $this->assertNull($response->attributes[2]->value);
    }

    public function testDeserializeUsersResponse() {
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
        }
    ]
}
JSON;
        /** @var UsersResponse $response */
        $response = $this->deserialize($json, UsersResponse::class);

        $this->assertInstanceOf(UsersResponse::class, $response);
        $this->assertEquals(1, count($response->users));

        /** @var UserResponse $user */
        $user = $response->users[0];

        $this->assertInstanceOf(UserResponse::class, $user);
    }

    public function testDeserializeUpdatedUsersResponse() {
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

        $response = $this->deserialize($json, UpdatedUsersResponse::class);

        $this->assertInstanceOf(UpdatedUsersResponse::class, $response);
        $this->assertEquals(1, count($response->users));
        $this->assertInstanceOf(UserUpdateInformation::class, $response->users[0]);
        $this->assertEquals('user1', $response->users[0]->username);
        $this->assertEquals(new \DateTime('2018-01-01 00:00:00 +0100'), $response->users[0]->updated);
    }
}