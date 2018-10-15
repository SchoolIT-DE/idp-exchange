<?php

namespace SchoolIT\IdpExchange\Request\Builder;

use SchoolIT\IdpExchange\Request\UpdatedUsersRequest;

class UpdatedUsersRequestBuilder {
    /**
     * @var string[]
     */
    private $usernames = [ ];

    /**
     * @var \DateTime
     */
    private $since = null;

    /**
     * @param string $username
     * @return $this
     */
    public function addUser(string $username): UpdatedUsersRequestBuilder {
        $this->usernames[] = $username;
        return $this;
    }

    /**
     * @param string[] $users
     * @return UpdatedUsersRequestBuilder
     */
    public function addUsers(array $users): UpdatedUsersRequestBuilder {
        $this->usernames = array_merge($this->usernames, $users);
        return $this;
    }

    /**
     * @param \DateTime $dateTime
     * @return UpdatedUsersRequestBuilder
     */
    public function since(\DateTime $dateTime): UpdatedUsersRequestBuilder {
        $this->since = $dateTime;
        return $this;
    }

    /**
     * @return UpdatedUsersRequest
     */
    public function build(): UpdatedUsersRequest {
        $request = new UpdatedUsersRequest();
        $request->usernames = $this->usernames;
        if($this->since !== null) {
            $request->since = clone $this->since;
        }

        return $request;
    }
}