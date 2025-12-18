<?php

declare(strict_types=1);

namespace Inn\App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
class Env
{
    public function __construct(public string $key, public mixed $default = null)
    {

    }
}