<?php declare(strict_types=1);

namespace Result;

/**
 * @template E
 * @extends Result<E>
 */
final class Err extends Result
{
    /**
     * @var E
     */
    protected $value;

    public function isErr(): bool
    {
        return true;
    }

    /**
     * @template U
     * @param callable(E):U $callback
     * @return Result<E>
     */
    public function map(callable $callback): Result
    {
        return $this;
    }

    /**
     * @template U
     * @param U $default
     * @param callable(mixed):U $callback
     * @return U
     */
    public function mapOr($default, callable $callback)
    {
        return $default;
    }

    /**
     * @template U
     * @param callable(E):U $callback
     * @return Result<U>
     */
    public function mapErr(callable $callback): Result
    {
        return new self($callback($this->value));
    }

    /**
     * @return no-return
     * @throws Panic
     */
    public function unwrap(): void
    {
        throw new Panic((string) $this->value);
    }

    /**
     * @param string $message
     * @return E
     */
    public function expectErr(string $message)
    {
        return $this->value;
    }
}