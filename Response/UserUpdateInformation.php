<?php

namespace SchoolIT\IdpExchange\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * Represents information about when a given user has been updated.
 */
class UserUpdateInformation
{
    /**
     * @Serializer\Type("string")
     */
    public $username;

    /**
     * @Serializer\Type("DateTime")
     */
    public $updated;
}