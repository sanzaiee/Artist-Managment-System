<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ArtistServices extends BaseService
{
    public function getArtists()
    {
        try {
            $query = "SELECT * FROM artists";
            $artists = DB::select($query);

            return $this->handleResponse(true,200,$artists);
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch artists');
        }
    }

    public function getArtistsForDropdown()
    {
        try {
            $query = "SELECT id,name FROM artists";
            $artists = DB::select($query);

            return $this->handleResponse(true,200,collect($artists)->pluck('name','id'));

        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch artists');
        }
    }


    public function getArtistsWithPagination($request)
    {
        try {
            $perPage = $request->input('perPage', 5);
            $page = $request->input('page', 1);
            $offset = ($page -1) * $perPage;
            $search = $request->input('search', '');

            $baseQuery = "SELECT * FROM artists ORDER BY created_at DESC ";
            $countQuery = "SELECT COUNT(*) as total FROM artists";
            $params = [];

            if(!empty($search)){
                $baseQuery .= " WHERE name LIKE ?";
                $countQuery .= " WHERE name LIKE ?";
                $params[] = "%$search%";
            }

            $total = DB::selectOne($countQuery, $params)->total ?? 0;

            $baseQuery .= " LIMIT $perPage OFFSET $offset";
            $artists = DB::select($baseQuery, $params);

            $paginator = new LengthAwarePaginator($artists,$total, $perPage, $page,[
                'path' => $request->url(),
                'query' => $request->query()
            ]);

            return  $this->handleResponse(true,200,['artists' => $paginator, 'search' => $search]);

        }catch(\Exception $e){
            $this->logError($e);
            return  $this->handleResponse(false,404,[],'Failed to fetch paginated artists');
        }
    }

    public function getArtist($id)
    {
        try {
            $query = "SELECT * FROM artists WHERE id = ?";
            $artist = DB::select($query,[$id]);

            return $this->handleResponse(true,200,$artist[0]);
        }catch (\Exception $e)
        {
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch artists');
        }
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

            return $this->handleResponse(true,200,[],'Artist created successfully');
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to store artists');
        }
    }

    public function updateArtist($data,$artistId)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $formattedData[] = $artistId;
            $query = "UPDATE artists SET name =?, address =?,gender=?,dob=?,first_release_year=?,no_of_albums_released=?,updated_at = NOW() WHERE id =?";
            DB::update($query, $formattedData);

            return $this->handleResponse(true,200,[],'Artist updated successfully');
        }catch(\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to update artists');
        }
    }

    public function deleteArtist($id)
    {
        try {
            $query = "DELETE FROM artists WHERE id = ?";
            DB::delete($query,[$id]);

            return $this->handleResponse(true,200,[],'Artist deleted successfully');
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to delete artists');
        }
    }

    public function artistMusic($request,$id)
    {
        try{
            $perPage = $request->input('perPage', 5);
            $page = $request->input('page', 1);
            $offset = ($page -1) * $perPage;
            $search = $request->input('search', '');

            $baseQuery = "SELECT artists.name as artist_name, music.*
                        FROM artists
                        JOIN music ON artists.id = music.artist_id
                        WHERE artists.id = ?
                        ORDER BY artists.created_at ASC
                       ";

            $countQuery = "SELECT COUNT(*) as total FROM music
                         WHERE music.artist_id = ?";
            $params[] = $id;

            if(!empty($search)){
                $baseQuery .= " AND music.title LIKE ?";
                $countQuery .= " AND title LIKE ?";
                $params[] = "%$search%";
            }

            $total = DB::selectOne($countQuery, $params)->total ?? 0;
            $baseQuery .= " LIMIT $perPage OFFSET $offset";

            $artists = DB::select($baseQuery, $params);

            $paginator = new LengthAwarePaginator($artists,$total, $perPage, $page,[
                'path' => $request->url(),
                'query' => $request->query()
            ]);

            return $this->handleResponse(true,200,$paginator);

        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch artist music');
        }
    }
}
