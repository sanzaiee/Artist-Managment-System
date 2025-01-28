<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
class UserController extends BaseController
{
    private $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }
    public function index(Request $request)
    {
        $this->authorize('view', User::class);
        $users = $this->userServices->getUsers();
        return view('users.list',compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('users.form');
    }

    public function edit($id)
    {
        $this->authorize('update', User::class);
        $user = $this->userServices->getUser($id);
        $data = $user->getData();
        if(!empty($data)){
            return view('users.form',['user' => $data[0]]);
        }
        return back()->withErrors('User not found!');
    }

    public function destroy($id)
    {
        $this->authorize('delete', User::class);
        $response = $this->userServices->deleteUser($id);
        $response = $response->getData();
        if($response->status === true){
            return to_route('users.index')->with('success',$response->message);
        }
        return back()->withErrors('User not found!');
    }
}
