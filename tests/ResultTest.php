<?php declare(strict_types=1);

namespace Result\Test;

use Result\Err;
use Result\Ok;
use Result\Panic;
use Result\Result;
use function PHPUnit\Framework\{assertFalse, assertInstanceOf, assertSame, assertTrue};
use function Result\Test\ok;

require_once __DIR__ . '/../vendor/autoload.php';

it('has an Ok factory', function () {
    assertInstanceOf(Ok::class, ok());
    assertTrue(ok()->isOk());
    assertFalse(ok()->isErr());
});

it('has an Err factory', function () {
    assertInstanceOf(Err::class, err());
    assertTrue(err()->isErr());
    assertFalse(err()->isOk());
});

it('can be compared', function () {
    assertFalse(ok()->equals(err()));
    assertTrue(ok()->equals(ok()));
    assertTrue(err()->equals(err()));
    assertFalse(ok(1)->equals(ok(2)));
    assertFalse(err(1)->equals(err(2)));
    assertTrue(ok(1)->equals(ok(1)));
    assertTrue(err(1)->equals(err(1)));
});

it('maps the wrapped value', function () {
    assertTrue(err()->map(fn($a) => $a)->equals(err()));
    assertTrue(ok(2)->map(fn($a) => $a * $a)->equals(ok(4)));

    assertSame(3, ok('foo')->mapOr(42, 'strlen'));
    assertSame(42, err('foo')->mapOr(42, 'strlen'));

    assertTrue(err(2)->mapErr(fn($a) => $a * $a)->equals(err(4)));
    assertTrue(ok(2)->mapErr(fn($a) => $a * $a)->equals(ok(2)));
});

it('throws panic when unwrapping err', function () {
    err('test')->unwrap();
})->throws(Panic::class, 'test');

it('unwraps value when ok', function() {
    assertSame(1, ok(1)->unwrap());
});

it('throws panic when expecting err in ok', function () {
    ok(10)->expectErr('Testing expect_err');
})->throws(Panic::class, 'Testing expect_err: 10');

it('unwraps err value when expected', function() {
    assertSame('Testing expect_err', err('Testing expect_err')->expectErr('foobar'));
});