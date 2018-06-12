<?php

namespace SchoolIT\IdpExchange\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a request for users which has been updated since a specific date. Optionally, you can specify users which
 * are checked for updates. This makes it possible to only check if certain users have been updated.
 */
class UpdatedUsersRequest {
    /**
     * @Serializer\Type("array<string>")
     */
    public $users = [ ];

    /**
     * @Serializer\Type("DateTime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    public $since = null;
}