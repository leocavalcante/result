<?php declare(strict_types=1);

namespace Result;

use JsonSerializable;

/**
 * @template T
 */
abstract class Result implements JsonSerializable
{
    /**
     * @var T
     */
    protected $value;

    /**
     * @param T $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @template ST
     * @param ST $value
     * @return Ok<ST>
     */
    public static function ok($value): Ok
    {
        return new Ok($value);
    }

    /**
     * @template SE
     * @param SE $value
     * @return Err<SE>
     */
    public static function err($value): Err
    {
        return new Err($value);
    }

    public function isOk(): bool
    {
        return false;
    }

    public function isErr(): bool
    {
        return false;
    }

    public function equals(Result $other): bool
    {
        return $other instanceof static && $other->value === $this->value;
    }

    /**
     * @return T
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * @template U
     * @param callable(T):U $callback
     * @return Result<U>|Result<T>
     */
    abstract public function map(callable $callback): Result;

    /**
     * @template U
     * @param U $default
     * @param callable(T):U $callback
     * @return Result<U>|U
     */
    abstract public function mapOr($default, callable $callback);

    /**
     * @template U
     * @param callable(T):U $callback
     * @return Result<U>|Result<T>
     */
    abstract public function mapErr(callable $callback): Result;

    /**
     * @return T
     */
    abstract public function unwrap();

    /**
     * @param string $message
     * @return T
     */
    abstract public function expectErr(string $message);
}
