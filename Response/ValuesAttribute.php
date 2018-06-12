<?php

namespace SchoolIT\IdpExchange\Response;

use JMS\Serializer\Annotation as Serializer;

class ValuesAttribute extends AbstractAttribute {

    /**
     * @Serializer\Type("array<string>")
     */
    public $values = [ ];
}