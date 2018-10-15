<?php

namespace SchoolIT\IdpExchange\Request\Builder;

use SchoolIT\IdpExchange\Request\UsersRequest;

class UsersRequestBuilder {
    /**
     * @var string[]
     */
    private $usernames = [ ];

    /**
     * @param string $user
     * @return UsersRequestBuilder
     */
    public function addUser(string $user): UsersRequestBuilder {
        $this->usernames[] = $user;
        return $this;
    }

    /**
     * @param string[] $users
     * @return UsersRequestBuilder
     */
    public function addUsers(array $users): UsersRequestBuilder {
        $this->usernames = array_merge($this->usernames, $users);
        return $this;
    }

    /**
     * @return UsersRequest
     */
    public function build(): UsersRequest {
        $request = new UsersRequest();
        $request->usernames = $this->usernames;

        return $request;
    }
}