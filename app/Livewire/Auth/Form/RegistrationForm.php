<?php

namespace App\Livewire\Auth\Form;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegistrationForm extends Form
{
    public $user = null;

    #[Validate(['required', 'string', 'max:255'])]
    public $first_name;

    #[Validate(['required', 'string', 'max:255'])]
    public $last_name;

    #[Validate(['required', 'string', 'max:255'])]
    public $address;

    #[Validate('required|digits:10')]
    public ?string $phone;

    #[Validate(['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class ])]
    public $email;

    #[Validate(['required','confirmed', 'min:6'])]
    public $password;

    #[Validate(['required'])]
    public $password_confirmation;

    #[Validate(['required','in:m,f,o'])]
    public $gender = null;

    #[Validate(['required','date'])]
    public $dob;

    #[Validate(['nullable','in:super_admin,artist,artist_manager'])]
    public $role_type;

    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                $this->user
                    ? 'unique:users,email,' . $this->user->id
                    : 'unique:users,email'
            ],
            'password' => [
                'required_if:$this->user,==,null'
            ],
            'password_confirmation' => [
                'required_if:$this->user,==,null'
            ]
        ];
    }
    public function setUserDetail($user)
    {
        if($user){
            $this->user = $user;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->phone = $user->phone;
            $this->email = $user->email;
            $this->gender = $user->gender;
            $this->dob = $user->dob;
            $this->address = $user->address;
            $this->role_type = $user->role_type;
        }
    }



}
