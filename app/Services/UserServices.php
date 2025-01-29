<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserServices extends BaseService
{
    public function getUsers()
    {
        try {
            $query = "SELECT * FROM users";
            $users = DB::select($query);

            return $this->handleResponse(true,200,$users);
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch users');
        }
    }

    public function getUsersWithPagination($request)
    {
        try {

            $perPage = $request->input('perPage', 5);
            $page = $request->input('page', 1);
            $offset = ($page -1) * $perPage;
            $search = $request->input('search', '');

            $baseQuery = "SELECT * FROM users";
            $countQuery = "SELECT COUNT(*) as total FROM users";
            $params = [];

            if(!empty($search)){
                $baseQuery .= " WHERE first_name LIKE ? OR last_name LIKE ?";
                $countQuery .= " WHERE first_name LIKE ? OR last_name LIKE ?";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            $total = DB::selectOne($countQuery, $params)->total ?? 0;

            $baseQuery .= " LIMIT $perPage OFFSET $offset";
            $users = DB::select($baseQuery, $params);


            $paginator = new LengthAwarePaginator($users,$total, $perPage, $page,[
                'path' => $request->url(),
                'query' => $request->query()
            ]);

            return  $this->handleResponse(true,200,['users' => $paginator, 'search' => $search],'Failed to fetch paginated users');
        }catch(\Exception $e){
            $this->logError($e);
            return  $this->handleResponse(false,404,[],'Failed to fetch paginated users');
        }
    }

    public function getUser($id)
    {
        try {
            $query = "SELECT * FROM users WHERE id = ?";
            $user = DB::select($query,[$id]);

            return $this->handleResponse(true,200,$user[0]);
        }catch (\Exception $e)
        {
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch artists');
        }
    }

    public function storeUser($data)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $query = "INSERT INTO users (first_name,last_name,email,phone,address,role_type,gender,dob,password,created_at,updated_at)
                        VALUES (?,?,?,?,?,?,?,?,?,NOW(),NOW())";
            DB::insert($query,$formattedData);

            return $this->handleResponse(true,200,[],'User created successfully');

        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to store user');
        }
    }

    public function updateUser($data,$userId)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $formattedData[] = $userId;
            $query = "UPDATE users SET first_name =?, last_name =?,email= ?,phone=?,address =?,role_type=?,gender=?,dob=?,password=?, updated_at = NOW() WHERE id =?";
            DB::update($query, $formattedData);

            return $this->handleResponse(true,200,[],'User updated successfully');

        }catch(\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to update user');
        }
    }

    private function formattedUserData($data): array
    {
        return  [
            $data['first_name'], $data['last_name'],$data['email'],$data['phone'],
            $data['address'], $data['role_type'],$data['gender'],$data['dob'],$data['password']
        ];
    }

    public function deleteUser($id)
    {
        try {
            $query = "DELETE FROM users WHERE id = ?";
            DB::delete($query,[$id]);

            return $this->handleResponse(true,200,[],'User deleted successfully');
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to delete user');
        }
    }
}
