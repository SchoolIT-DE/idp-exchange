<?php

namespace SchoolIT\IdpExchange\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Requests information for a specific user.
 */
class UserRequest {
    /**
     * Username of the requested user.
     *
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public $username;
}