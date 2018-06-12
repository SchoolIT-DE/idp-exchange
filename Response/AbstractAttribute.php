<?php

namespace SchoolIT\IdpExchange\Response;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\Discriminator(field="type", map={"single": "SchoolIT\IdpExchange\Response\ValueAttribute", "multiple": "SchoolIT\IdpExchange\Response\ValuesAttribute"})
 */
abstract class AbstractAttribute {
    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public $name;
}