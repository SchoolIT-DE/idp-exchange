<?php

namespace SchoolIT\IdpExchange\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Requests information for specific users.
 */
class UsersRequest {
    /**
     * List of usernames for which the information is requested.
     *
     * @Serializer\Type("array<string>")
     * @Assert\Count(min="1")
     * @var string[]
     */
    public $users = [ ];
}