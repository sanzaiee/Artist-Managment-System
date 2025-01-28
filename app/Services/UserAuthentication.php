<?php

namespace App\Services;

use App\Models\User;

class UserAuthentication
{
    protected $user;
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register($data)
    {
        return $data;
    }
}
