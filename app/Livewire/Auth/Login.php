<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.guest')]

class Login extends Component
{
    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        dd(12);
    }
}
