<?php

namespace SchoolIT\IdpExchange\Response\Builder;

use SchoolIT\IdpExchange\Response\UserUpdateInformation;
use SchoolIT\IdpExchange\Response\UpdatedUsersResponse;

class UpdatedUsersResponseBuilder {

    /**
     * @var UserUpdateInformation[]
     */
    private $users = [ ];

    /**
     * @param string $username
     * @param \DateTime $updated
     * @return UpdatedUsersResponseBuilder
     */
    public function addUser(string $username, \DateTime $updated): UpdatedUsersResponseBuilder {
        $user = new UserUpdateInformation();
        $user->username = $username;
        $user->updated = $updated;

        $this->users[] = $user;
        return $this;
    }

    /**
     * @return UpdatedUsersResponse
     */
    public function build(): UpdatedUsersResponse {
        $response = new UpdatedUsersResponse();
        $response->users = $this->users;

        return $response;
    }
}