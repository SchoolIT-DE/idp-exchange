<?php

namespace SchoolIT\IdpExchange\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a request for a list of users.
 */
class UsersRequest {
    /**
     * @Serializer\Type("array<string>")
     * @Assert\Length(min="1")
     * @var string[]
     */
    public $users = [ ];
}