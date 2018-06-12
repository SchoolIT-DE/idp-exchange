<?php

namespace SchoolIT\IdpExchange\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a request for a specific user.
 */
class UserRequest {
    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public $username;
}