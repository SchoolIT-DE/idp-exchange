<?php

namespace SchoolIT\IdpExchange\Request\Builder;

use SchoolIT\IdpExchange\Request\UsersRequest;

class UsersRequestBuilder {
    /**
     * @var string[]
     */
    private $users = [ ];

    /**
     * @param string $user
     * @return UsersRequestBuilder
     */
    public function addUser(string $user): UsersRequestBuilder {
        $this->users[] = $user;
        return $this;
    }

    /**
     * @param string[] $users
     * @return UsersRequestBuilder
     */
    public function addUsers(array $users): UsersRequestBuilder {
        $this->users = array_merge($this->users, $users);
        return $this;
    }

    /**
     * @return UsersRequest
     */
    public function build(): UsersRequest {
        $request = new UsersRequest();
        $request->users = $this->users;

        return $request;
    }
}