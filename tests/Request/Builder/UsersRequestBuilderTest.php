<?php

namespace SchoolIT\IdpExchange\Tests\Request\Builder;

use PHPUnit\Framework\TestCase;
use SchoolIT\IdpExchange\Request\Builder\UsersRequestBuilder;

class UsersRequestBuilderTest extends TestCase {
    public function testAddUser() {
        $request = (new UsersRequestBuilder())
            ->addUser('foo')
            ->addUser('bla')
            ->build();

        $this->assertEquals(2, count($request->usernames));
        $this->assertEquals('foo', $request->usernames[0]);
        $this->assertEquals('bla', $request->usernames[1]);
    }

    public function testAddUsers() {
        $request = (new UsersRequestBuilder())
            ->addUser('foo')
            ->addUsers(['bla'])
            ->build();

        $this->assertEquals(2, count($request->usernames));
        $this->assertEquals('foo', $request->usernames[0]);
        $this->assertEquals('bla', $request->usernames[1]);
    }
}