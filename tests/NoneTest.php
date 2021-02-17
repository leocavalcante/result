<?php declare(strict_types=1);

use Result\None;

it('represents a unit value', function () {
    $none = new None();
    expect(json_encode($none, JSON_THROW_ON_ERROR))->toBe('"None"');
    expect((string) $none)->toBe('None');
});