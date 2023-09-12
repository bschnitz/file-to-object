<?php

namespace FileToObject\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY)]
class Keyed
{
    public function __construct(public string $class, public string $key) {}
}
