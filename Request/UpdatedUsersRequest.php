<?php

namespace SchoolIT\IdpExchange\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a request for users which has been updated since a specific date.
 */
class UpdatedUsersRequest {
    /**
     * List of usernames which are checked for any updates.
     *
     * @Serializer\Type("array<string>")
     * @Assert\Count(min="1")
     */
    public $usernames = [ ];

    /**
     * @Serializer\Type("DateTime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    public $since = null;
}