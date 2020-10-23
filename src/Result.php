<?php declare(strict_types=1);

namespace Result;

/**
 * @template T
 * @template E
 */
abstract class Result
{
    /**
     * @var mixed
     * @psalm-var T|E|None
     */
    protected $value;

    /**
     * @param mixed $value
     * @psalm-param T|E|None $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @template ST
     * @param mixed $value
     * @psalm-param ST $value
     * @return Ok
     * @psalm-return Ok<ST>
     */
    public static function ok($value): Ok
    {
        return new Ok($value);
    }

    /**
     * @template SE
     * @param mixed $value
     * @psalm-param SE $value
     * @return Err
     * @psalm-return Err<SE>
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
     * @template U
     * @param callable(T):U $callback
     * @return Result
     * @psalm-return Result<U, E>|Result<T, E>
     */
    abstract public function map(callable $callback): Result;

    /**
     * @template U
     * @param mixed $default
     * @psalm-param U $default
     * @param callable(T):U $callback
     * @return mixed
     * @psalm-return U
     */
    abstract public function mapOr($default, callable $callback);

    /**
     * @template U
     * @param callable(E|None):U $callback
     * @return Result
     * @psalm-return Result<T, U>|Result<T, E>
     */
    abstract public function mapErr(callable $callback): Result;

    /**
     * @return mixed
     * @psalm-return T
     */
    abstract public function unwrap();

    /**
     * @param string $message
     * @return mixed
     * @psalm-return E
     */
    abstract public function expectErr(string $message);
}