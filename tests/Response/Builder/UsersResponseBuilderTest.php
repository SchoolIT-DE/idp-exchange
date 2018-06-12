<?php

namespace SchoolIT\IdpExchange\Response\Builder;

use PHPUnit\Framework\TestCase;

class UsersResponseBuilderTest extends TestCase {
    public function testAddUser() {
        $user1 = (new UserResponseBuilder())
            ->setUsername('foo')
            ->build();

        $user2 = (new UserResponseBuilder())
            ->setUsername('bla')
            ->build();

        $response = (new UsersResponseBuilder())
            ->addUser($user1)
            ->addUser($user2)
            ->build();

        $this->assertEquals(2, count($response->users));
        $this->assertEquals($user1, $response->users[0]);
        $this->assertEquals($user2, $response->users[1]);
    }
}