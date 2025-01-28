<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getUsers()
    {
        $query = "SELECT * FROM users";
        return $users = DB::select($query);
        return response()->json($users);
    }

    public function getUsersWithPagination($request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $offset = ($page -1) * $perPage;
        $search = $request->input('search', '');

        $baseQuery = "SELECT * FROM users";
        $countQuery = "SELECT COUNT(*) as total FROM users";

        if(!empty($search)){
            $baseQuery .= "WHERE name LIKE ?";
            $countQuery .= "WHERE name LIKE ?";
        }

        $total = DB::selectOne($countQuery, ["%$search%"])->total ?? 0;

        $baseQuery .= "LIMIT ? OFFSET ?";
        $users = DB::select($baseQuery, empty($search)  ? [$perPage, $offset] : ["%$search%", $perPage, $offset]);

        $paginator = new LengthAwarePaginator($users,$total, $perPage, $page,[
            'path' => $request->url(),
            'query' => $request->query()
        ]);

        return response()->json(['users' => $paginator, 'search' => $search]);
    }

    public function getUser($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $user = DB::select($query,[$id]);

        return response()->json($user);
    }

    public function storeUser($data)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $query = "INSERT INTO users (first_name,last_name,email,phone,address,role_type,gender,dob,password,created_at,updated_at)
                        VALUES (?,?,?,?,?,?,?,?,?,NOW(),NOW())";
            DB::insert($query,$formattedData);

            return response()->json(['status' => true,'message' => 'created successfully!']);
        }catch (\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }

    public function updateUser($data,$userId)
    {
        try {
        $formattedData = $this->formattedUserData($data);
        $formattedData[] = $userId;
        $query = "UPDATE users SET first_name =?, last_name =?,email= ?,phone=?,address =?,role_type=?,gender=?,dob=?,password=?, updated_at = NOW() WHERE id =?";
        DB::update($query, $formattedData);
        return response()->json(['status' => true,'message' => 'updated successfully!']);

        }catch(\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
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
            return response()->json(['status' => true,'message' => 'deleted successfully!']);
        }catch (\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }
}
