<?php declare(strict_types=1);

namespace Result\Test;

use Result\Err;
use Result\Ok;
use Result\Result;

function ok($value = null): Ok
{
    return Result::ok($value);
}

function err($value = null): Err
{
    return Result::err($value);
}