<?php

namespace App\Enums\MetaProperties;

use ArchTech\Enums\Meta\MetaProperty;
use Attribute;

#[Attribute()]
class Description extends MetaProperty
{
    protected function transform(mixed $value): mixed
    {
        return $value;
    }
}