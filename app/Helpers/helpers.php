<?php

use App\Models\Music;
use App\Models\User;
use Carbon\Carbon;

if(!function_exists('getGenreValue')) {
    function getGenreValue($value): string
    {
       return  Music::GENRE[$value] ?? "Unknown Genre";
    }
}

if(!function_exists('getGenderValue')) {
    function getGenderValue($value): string
    {
        return  User::GENDERS[$value] ?? "Unknown Genre";
    }
}

if(!function_exists('getDateFormat')) {
    function getDateFormat($value): string
    {
        return Carbon::parse($value)->format('d M Y, h:i A' );
    }
}



