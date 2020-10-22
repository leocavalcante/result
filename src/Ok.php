<?php declare(strict_types=1);

namespace Result;

/**
 * @template T
 * @extends Result<T, None>
 */
final class Ok extends Result
{
    /**
     * @var mixed
     * @psalm-var T
     */
    protected $value;

    public function isOk(): bool
    {
        return true;
    }

    /**
     * @template U
     * @param callable(T):U $callback
     * @return self
     * @psalm-return Ok<U>
     */
    public function map(callable $callback): self
    {
        return new self($callback($this->value));
    }

    /**
     * @template U
     * @param mixed $default
     * @param callable(T):U $callback
     * @return mixed
     * @psalm-return U
     */
    public function mapOr($default, callable $callback)
    {
        return $callback($this->value);
    }

    /**
     * @param callable $callback
     * @return $this
     * @psalm-return Ok<T>
     */
    public function mapErr(callable $callback): Result
    {
        return $this;
    }
}