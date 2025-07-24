<?php

declare(strict_types=1);

namespace Webauthn\AuthenticationExtensions;

final class UvmInputExtension extends AuthenticationExtension
{
    public static function enable(): AuthenticationExtension
    {
        return self::create('uvm', true);
    }

    public static function disable(): AuthenticationExtension
    {
        return self::create('uvm', false);
    }
}
