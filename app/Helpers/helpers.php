<?php

use App\Models\Music;
use App\Models\User;

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


