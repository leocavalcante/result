<?php declare(strict_types=1);

namespace Result;

/**
 * @template E
 * @extends Result<None, E>
 */
final class Err extends Result
{
    /**
     * @var mixed
     * @psalm-var E
     */
    protected $value;

    public function isErr(): bool
    {
        return true;
    }

    /**
     * @param callable $callback
     * @return $this
     * @psalm-return Err<E>
     */
    public function map(callable $callback): self
    {
        return $this;
    }

    /**
     * @template U
     * @param mixed $default
     * @psalm-param U $default
     * @param callable(mixed):U $callback
     * @return mixed
     * @psalm-return U
     */
    public function mapOr($default, callable $callback)
    {
        return $default;
    }

    /**
     * @template U
     * @param callable(E|None):U $callback
     * @return self
     * @psalm-return Err<U>
     */
    public function mapErr(callable $callback): self
    {
        return new self($callback($this->value));
    }

    /**
     * @throws Panic
     */
    public function unwrap()
    {
        throw new Panic((string)$this->value);
    }

    /**
     * @param string $message
     * @return mixed
     * @psalm-return E
     */
    public function expectErr(string $message)
    {
        return $this->value;
    }
}