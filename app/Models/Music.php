<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    const RNB = 'rnb';
    const COUNTRY = 'country';
    const CLASSIC = 'classic';
    const ROCK = 'rock';
    const JAZZ = 'jazz';
    const TEST = 'test';
    const GENRE = [
        self::RNB => 'R&B',
        self::COUNTRY => 'Country',
        self::CLASSIC => 'Classic',
        self::ROCK => 'Rock',
        self::JAZZ => 'Jazz',
        self::TEST => 'test',
    ];

}
