<?php declare(strict_types=1);

namespace Result\Test;

use Result\Err;
use Result\Ok;
use Result\Panic;
use Result\Result;

it("has an Ok factory", function (): void {
    $result = Result::ok(null);

    expect($result)
        ->toBeInstanceOf(Ok::class)
        ->and($result->isOk())
        ->toBeTrue()
        ->and($result->isErr())
        ->toBeFalse();
});

it("has an Err factory", function (): void {
    $result = Result::err(null);

    expect($result)
        ->toBeInstanceOf(Err::class)
        ->and($result->isOk())
        ->toBeFalse()
        ->and($result->isErr())
        ->toBeTrue();
});

it("can be compared", function (): void {
    expect(Result::ok(null)->equals(Result::err(null)))->toBeFalse();
    expect(Result::ok(null)->equals(Result::ok(null)))->toBeTrue();
    expect(Result::err(null)->equals(Result::err(null)))->toBeTrue();

    expect(Result::ok(1)->equals(Result::ok(1)))->toBeTrue();
    expect(Result::ok(1)->equals(Result::ok(2)))->toBeFalse();
    expect(Result::ok(1)->equals(Result::ok("1")))->toBeFalse();

    expect(Result::err(1)->equals(Result::err(1)))->toBeTrue();
    expect(Result::err(1)->equals(Result::err(2)))->toBeFalse();
    expect(Result::err(1)->equals(Result::err("1")))->toBeFalse();
});

it("maps the wrapped value", function (): void {
    expect(
        Result::err("first value")
            ->map(fn(string $fst_val): string => "second value")
            ->equals(Result::err("first value"))
    )->toBeTrue();

    expect(
        Result::ok("first value")
            ->map(fn(string $fst_val): string => "$fst_val, second value")
            ->equals(Result::ok("first value, second value"))
    )->toBeTrue();
});

it("maps the wrapped value or returns a default", function (): void {
    expect(
        Result::ok("first value")
            ->mapOr("default value", fn(string $fst_val): string => "$fst_val, second value")
            ->unwrap()
    )->toBe("first value, second value");

    expect(
        Result::err("first value")->mapOr("default value", fn(string $fst_val): string => "$fst_val, second value")
    )->toBe("default value");
});

it("maps the err", function (): void {
    expect(
        Result::ok("first value")
            ->mapErr(fn(string $fst_val): string => "second value")
            ->equals(Result::ok("first value"))
    )->toBeTrue();

    expect(
        Result::err("first value")
            ->mapErr(fn(string $fst_val): string => "$fst_val, second value")
            ->equals(Result::err("first value, second value"))
    )->toBeTrue();
});

it("throws panic when unwrapping err", function (): void {
    Result::err("test")->unwrap();
})->throws(Panic::class, "test");

it("unwraps value when ok", function (): void {
    expect(Result::ok(1)->unwrap())->toBe(1);
});

it("throws panic when expecting err in ok", function (): void {
    Result::ok(10)->expectErr("expect err");
})->throws(Panic::class, "expect err: 10");

it("unwraps err value when expected", function (): void {
    expect(Result::err("error value")->expectErr("error message"))->toBe("error value");
});

it("is Json serializable", function (): void {
    expect(json_encode(Result::ok("foo"), JSON_THROW_ON_ERROR))
        ->toBe('"foo"')
        ->and(json_encode(Result::err("bar"), JSON_THROW_ON_ERROR))
        ->toBe('"bar"');
});

it("stringifies", function (): void {
    expect((string) Result::ok("ok value"))->toBe("ok value");
    expect((string) Result::err("err value"))->toBe("err value");
});
