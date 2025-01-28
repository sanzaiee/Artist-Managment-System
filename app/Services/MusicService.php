<?php

namespace App\Services;

use App\Models\Music;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MusicService
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
        return $this->music::GENRE;
    }
    public function getMusics()
    {
        $query = "SELECT music.*,artists.name as artist_name
                    FROM music
                    JOIN artists ON artists.id = music.artist_id
                    ";
        return $music = DB::select($query);
        return response()->json($music);
    }

    public function getMusicsWithPagination($request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $offset = ($page -1) * $perPage;
        $search = $request->input('search', '');

        $baseQuery = "SELECT * FROM music";
        $countQuery = "SELECT COUNT(*) as total FROM music";

        if(!empty($search)){
            $baseQuery .= "WHERE name LIKE ?";
            $countQuery .= "WHERE name LIKE ?";
        }

        $total = DB::selectOne($countQuery, ["%$search%"])->total ?? 0;

        $baseQuery .= "LIMIT ? OFFSET ?";
        $music = DB::select($baseQuery, empty($search)  ? [$perPage, $offset] : ["%$search%", $perPage, $offset]);

        $paginator = new LengthAwarePaginator($music,$total, $perPage, $page,[
            'path' => $request->url(),
            'query' => $request->query()
        ]);

        return response()->json(['music' => $paginator, 'search' => $search]);
    }

    public function getMusic($id)
    {
        $query = "SELECT * FROM music WHERE id = ?";
        $artist = DB::select($query,[$id]);

        return response()->json(['status' => true,'data' => $artist]);
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

            return response()->json(['status' => true,'message' => 'created successfully!']);
        }catch (\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }

    public function updateMusic($data,$musicId)
    {
        try {
            $formattedData = $this->formattedUserData($data);
            $formattedData[] = $musicId;
            $query = "UPDATE music SET title =?, album_name =?,genre=?,artist_id=?,updated_at = NOW() WHERE id =?";
            DB::update($query, $formattedData);
            return response()->json(['status' => true,'message' => 'updated successfully!']);

        }catch(\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }

    public function deleteMusic($id)
    {
        try {
            $query = "DELETE FROM music WHERE id = ?";
            DB::delete($query,[$id]);
            return response()->json(['status' => true,'message' => 'deleted successfully!']);
        }catch (\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()]);
        }
    }
}
