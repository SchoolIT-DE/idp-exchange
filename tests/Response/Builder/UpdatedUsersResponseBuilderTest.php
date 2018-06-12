<?php

namespace SchoolIT\IdpExchange\Tests\Response\Builder;

use PHPUnit\Framework\TestCase;
use SchoolIT\IdpExchange\Response\Builder\UpdatedUsersResponseBuilder;
use SchoolIT\IdpExchange\Response\UserUpdateInformation;

class UpdatedUsersResponseBuilderTest extends TestCase {
    public function testAddUser() {
        $response = (new UpdatedUsersResponseBuilder())
            ->addUser('username', new \DateTime('2018-01-01 00:00:00'))
            ->build();

        $this->assertEquals(1, count($response->users));
        $this->assertInstanceOf(UserUpdateInformation::class, $response->users[0]);
        $this->assertEquals('username', $response->users[0]->username);
        $this->assertEquals(new \DateTime('2018-01-01 00:00:00'), $response->users[0]->updated);
    }
}