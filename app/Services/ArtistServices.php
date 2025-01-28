<?php

namespace App\Services;

use App\Models\Artist;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ArtistServices
{
    public function getArtists()
    {
        $query = "SELECT * FROM artists";
        return $artists = DB::select($query);
        return response()->json($artists);
    }

    public function getArtistsForDropdown()
    {
        $query = "SELECT id,name FROM artists";
        $artists = DB::select($query);
        return collect($artists)->pluck('name','id');
    }

    public function getArtistsWithPagination($request)
    {
        $perPage = $request->input('perPage', 5);
        $page = $request->input('page', 1);
        $offset = ($page -1) * $perPage;
        $search = $request->input('search', '');

        $baseQuery = "SELECT * FROM artists ";
        $countQuery = "SELECT COUNT(*) as total FROM artists";
        $params = [];

        if(!empty($search)){
            $baseQuery .= " WHERE name LIKE ?";
            $countQuery .= "WHERE name LIKE ?";
            $params = "%$search%";
        }

        $total = DB::selectOne($countQuery, $params)->total ?? 0;

        $baseQuery .= "LIMIT $perPage OFFSET $offset";
        $artists = DB::select($baseQuery, $params);

        $paginator = new LengthAwarePaginator($artists,$total, $perPage, $page,[
            'path' => $request->url(),
            'query' => $request->query()
        ]);

        return response()->json(['status' => true,'artists' => $paginator, 'search' => $search]);
    }

    public function getArtist($id)
    {
        $query = "SELECT * FROM artists WHERE id = ?";
        $artist = DB::select($query,[$id]);

        return response()->json(['status' => true,'data' => $artist]);
    }

    private function formattedUserData($data): array
    {
        return  [
            $data['name'],$data['address'],
            $data['gender'],$data['dob'],$data['first_release_year'],$data['no_of_albums_released']
        ];
    }

    public function storeArtist($data)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $query = "INSERT INTO artists (name,address,gender,dob,first_release_year,no_of_albums_released,created_at,updated_at)
                        VALUES (?,?,?,?,?,?,NOW(),NOW())";
            DB::insert($query,$formattedData);

            return response()->json(['status' => true,'message' => 'created successfully!']);
        }catch (\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }

    public function updateArtist($data,$artistId)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $formattedData[] = $artistId;
            $query = "UPDATE artists SET name =?, address =?,gender=?,dob=?,first_release_year=?,no_of_albums_released=?,updated_at = NOW() WHERE id =?";
            DB::update($query, $formattedData);
            return response()->json(['status' => true,'message' => 'updated successfully!']);

        }catch(\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }

    public function deleteArtist($id)
    {
        try {
            $query = "DELETE FROM artists WHERE id = ?";
            DB::delete($query,[$id]);
            return response()->json(['status' => true,'message' => 'deleted successfully!']);
        }catch (\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }
}
