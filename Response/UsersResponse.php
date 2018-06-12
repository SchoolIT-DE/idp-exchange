<?php

namespace SchoolIT\IdpExchange\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * Represents a response of a UsersRequest
 */
class UsersResponse {
    /**
     * @Serializer\Type("array<SchoolIT\IdpExchange\Response\UserResponse>")
     */
    public $users = [ ];
}