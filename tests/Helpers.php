<?php declare(strict_types=1);

namespace Result\Test;

use Result\Err;
use Result\Ok;
use Result\Result;

/**
 * @template T
 * @param T|null $value
 * @return Ok
 */
function ok($value = null): Ok
{
    return Result::ok($value);
}

/**
 * @template E
 * @param E|null $value
 * @return Err
 */
function err($value = null): Err
{
    return Result::err($value);
}