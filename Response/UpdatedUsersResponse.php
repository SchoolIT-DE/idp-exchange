<?php

namespace SchoolIT\IdpExchange\Response;

use JMS\Serializer\Annotation as Serializer;

class UpdatedUsersResponse {
    /**
     * @Serializer\Type("array<SchoolIT\IdpExchange\Response\UserUpdateInformation>")
     */
    public $users = [ ];
}