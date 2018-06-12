<?php

namespace SchoolIT\IdpExchange\Response\Builder;

use SchoolIT\IdpExchange\Response\UserResponse;
use SchoolIT\IdpExchange\Response\UsersResponse;

class UsersResponseBuilder {

    /**
     * @var UserResponse[]
     */
    private $users = [ ];

    /**
     * @param UserResponse $userResponse
     * @return UsersResponseBuilder
     */
    public function addUser(UserResponse $userResponse): UsersResponseBuilder {
        $this->users[] = $userResponse;
        return $this;
    }

    /**
     * @return UsersResponse
     */
    public function build(): UsersResponse {
        $response = new UsersResponse();

        foreach($this->users as $userResponse) {
            $response->users[] = clone $userResponse;
        }

        return $response;
    }
}