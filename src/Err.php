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
     * @param callable:U $callback
     * @return mixed
     * @psalm-return U
     */
    public function mapOr($default, callable $callback)
    {
        return $default;
    }
}