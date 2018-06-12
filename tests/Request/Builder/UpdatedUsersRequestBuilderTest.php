<?php

namespace SchoolIT\IdpExchange\Tests\Request\Builder;

use PHPUnit\Framework\TestCase;
use SchoolIT\IdpExchange\Request\Builder\UpdatedUsersRequestBuilder;

class UpdatedUsersRequestBuilderTest extends TestCase {
    public function testAddUser() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUser('username')
            ->build();

        $this->assertContains('username', $request->users);
    }

    public function testAddUsers() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUsers(['userOne', 'userTwo', 'userThree'])
            ->build();

        $this->assertContains('userOne', $request->users);
        $this->assertContains('userTwo', $request->users);
        $this->assertContains('userThree', $request->users);
    }

    public function testAddEmptyUsers() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUsers([])
            ->build();

        $this->assertEmpty($request->users);
    }
}