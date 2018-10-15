<?php

namespace SchoolIT\IdpExchange\Tests\Request\Builder;

use PHPUnit\Framework\TestCase;
use SchoolIT\IdpExchange\Request\Builder\UpdatedUsersRequestBuilder;

class UpdatedUsersRequestBuilderTest extends TestCase {
    public function testAddUser() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUser('username')
            ->build();

        $this->assertContains('username', $request->usernames);
    }

    public function testAddUsers() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUsers(['userOne', 'userTwo', 'userThree'])
            ->build();

        $this->assertContains('userOne', $request->usernames);
        $this->assertContains('userTwo', $request->usernames);
        $this->assertContains('userThree', $request->usernames);
    }

    public function testAddEmptyUsers() {
        $request = (new UpdatedUsersRequestBuilder())
            ->addUsers([])
            ->build();

        $this->assertEmpty($request->usernames);
    }
}