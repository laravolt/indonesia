<?php

namespace Laravolt\Indonesia;

final class Permission
{
    const MANAGE_INDONESIA = 'indonesia::manage-all';

    public static function toArray()
    {
        return [self::MANAGE_INDONESIA];
    }
}
