<?php

namespace App\Livewire\Auth;

use App\Eums\UserRole;
use App\Livewire\Auth\Form\RegistrationForm;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Registration extends Component
{
    public RegistrationForm $form;
    public bool $create = false;
    public array $role_types = [];
    public array $gender_types = [];
    public $user = null;

    public function render()
    {
        return view('livewire.auth.registration');
    }
    public function mount($create = false, $user = null)
    {
        $this->create = $create;
        $this->user = $user;
        $this->gender_types = User::GENDERS;

        if($this->create)
        {
            $this->role_types = UserRole::all();
            $this->form->setUserDetail($user);
        }
    }
    public function save(){
        $rules = $this->form->getRules();
        $data = $this->form->validate(array_merge($rules,$this->form->rules()));
        $registration = $this->updataOrCreate($data);

        $response = $registration->getData();
        if($response->status === true){
            if($this->create)
            {
                $this->authorize('create', User::class);
                return to_route('users.index');
            }
//            $this->login($registration); //handles login after registration
            return to_route('login');
        }else{
            Log::error('Failed register user ',[
                'error' => $response->message
            ]);
            throw new \RuntimeException($response->message);
        }
    }
    /**
        update or create function is handles registration, create and update user
     **/
    private function updataOrCreate($data)
    {
        $userService = new UserServices();
        try {
            if($this->user){
                $this->authorize('create', User::class);
                $data['password'] = $this->user->password;
                return $userService->updateUser($data,$this->user->id);
            }else{
                $data['password'] = Hash::make($data['password']);
                $data['role_type'] = $data['role_type'] ?? UserRole::SUPER_ADMIN->value;
                if($this->create){
                    $this->authorize('update', User::class);
                }
                return $userService->storeUser($data);
            }
        }catch(\Exception $e){
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function login($user)
    {
        auth()->login($user);
    }
}
