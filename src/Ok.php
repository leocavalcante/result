<?php declare(strict_types=1);

namespace Result;

/**
 * @template T
 * @extends Result<T>
 */
final class Ok extends Result
{
    /**
     * @var T
     */
    protected $value;

    public function isOk(): bool
    {
        return true;
    }

    /**
     * @template U
     * @param callable(T):U $callback
     * @return Result<U>
     */
    public function map(callable $callback): Result
    {
        return new self($callback($this->value));
    }

    /**
     * @template U
     * @param mixed $default
     * @param callable(T):U $callback
     * @return Result<U>
     */
    public function mapOr($default, callable $callback): Result
    {
        return new self($callback($this->value));
    }

    /**
     * @template U
     * @param callable(T):U $callback
     * @return Result<T>
     */
    public function mapErr(callable $callback): Result
    {
        return $this;
    }

    /**
     * @return T
     */
    public function unwrap()
    {
        return $this->value;
    }

    /**
     * @param string $message
     * @return no-return
     * @throws Panic
     */
    public function expectErr(string $message): void
    {
        throw new Panic(sprintf("$message: %s", (string) $this->value));
    }
}
