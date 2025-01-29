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
        $response = $this->userServices->getUsersWithPagination($request)->getData();

        if(!$response->status){
            return back()->withErrors('Failed to load users');
        }

        return view('users.list',[
            'users' => $response->data->users,
            'search' => $response->data->search
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('users.form');
    }

    public function edit($id)
    {
        $this->authorize('update', User::class);
        $response = $this->userServices->getUser($id)->getData();
        if(!$response->status){
            return back()->withErrors('User not found!');

        }
        return view('users.form',['user' => $response->data]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', User::class);

        return $this->handelResponse(
            $this->userServices->deleteUser($id),
            'users.index'
        );
    }
}
