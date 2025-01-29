<?php

namespace App\Services;

use App\Models\Music;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MusicService extends BaseService
{
    private $music;
    /**
     * Create a new class instance.
     */
    public function __construct(Music $music)
    {
        $this->music = $music;
    }

    public function getGenre()
    {
        return $this->handleResponse(true,200,$this->music::GENRE);
    }
    public function getMusics()
    {
        try {
            $query = "SELECT music.*,artists.name as artist_name
                    FROM music
                    JOIN artists ON artists.id = music.artist_id
                    ";
            $music = DB::select($query);

            return $this->handleResponse(true,200,$music);
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch music');
        }
    }

    public function getMusicsWithPagination($request)
    {
        try {

            $perPage = $request->input('perPage', 5);
            $page = $request->input('page', 1);
            $offset = ($page -1) * $perPage;
            $search = $request->input('search', '');

            $baseQuery = "SELECT music.*,artists.name as artist_name
                        FROM music
                        JOIN artists ON artists.id = music.artist_id";

            $countQuery = "SELECT COUNT(*) as total FROM music";
            $params = [];

            if(!empty($search)){
                $baseQuery .= " WHERE title LIKE ?";
                $countQuery .= " WHERE title LIKE ?";
                $params[] = "%$search%";
            }
            $total = DB::selectOne($countQuery, $params)->total ?? 0;

            $baseQuery .= " LIMIT $perPage OFFSET $offset";
            $music = DB::select($baseQuery, $params);
            $paginator = new LengthAwarePaginator($music,$total, $perPage, $page,[
                'path' => $request->url(),
                'query' => $request->query()
            ]);

            return  $this->handleResponse(true,200,['music' => $paginator, 'search' => $search]);
        }catch(\Exception $e){
            $this->logError($e);
            return  $this->handleResponse(false,404,[],'Failed to fetch paginated music');
        }
    }

    public function getMusic($id)
    {
        try {
            $query = "SELECT music.*,artists.name as artist_name
                        FROM music
                        JOIN artists ON artists.id = music.artist_id
                        WHERE music.id = ?";
            $music = DB::select($query,[$id]);

            return $this->handleResponse(true,200,$music[0]);
        }catch (\Exception $e)
        {
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to fetch music');
        }
    }

    private function formattedUserData($data): array
    {
        return  [
            $data['title'],$data['album_name'],$data['genre'],$data['artist_id']
        ];
    }

    public function storeMusic($data)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $query = "INSERT INTO music (title,album_name,genre,artist_id,created_at,updated_at)
                        VALUES (?,?,?,?,NOW(),NOW())";
            DB::insert($query,$formattedData);

            return $this->handleResponse(true,200,[],'Music created successfully');
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to store music');
        }
    }

    public function updateMusic($data,$musicId)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $formattedData[] = $musicId;
            $query = "UPDATE music SET title =?, album_name =?,genre=?,artist_id=?,updated_at = NOW() WHERE id =?";
            DB::update($query, $formattedData);
            return $this->handleResponse(true,200,[],'Music updated successfully');

        }catch(\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to update music');
        }
    }

    public function deleteMusic($id)
    {
        try {
            $query = "DELETE FROM music WHERE id = ?";
            DB::delete($query,[$id]);

            return $this->handleResponse(true,200,[],'Music deleted successfully');
        }catch (\Exception $e){
            $this->logError($e);
            return $this->handleResponse(false,404,[],'Failed to delete music');
        }
    }
}
