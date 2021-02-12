<?php declare(strict_types=1);

namespace Result;

use JsonSerializable;

final class None implements JsonSerializable
{
    public function __construct()
    {
    }

    public function jsonSerialize(): string
    {
        return 'None';
    }

    public function __toString(): string
    {
        return 'None';
    }
}