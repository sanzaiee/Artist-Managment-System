<?php

namespace App\Eums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case ARTIST_MANAGER = 'artist_manager';
    case ARTIST = 'artist';

    public static function all(): array
    {
       return [
            self::SUPER_ADMIN->value => 'Super Admin',
            self::ARTIST_MANAGER->value => 'Artist Manager',
            self::ARTIST->value => 'Artist',
        ];
    }

    public static function getName(string $role): string
    {
        return self::all()[$role] ?? 'Unknown role';
    }

}
