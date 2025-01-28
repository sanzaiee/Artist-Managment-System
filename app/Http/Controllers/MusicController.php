<?php

namespace App\Http\Controllers;

use App\Http\Requests\Music\MusicRequest;
use App\Models\Music;
use App\Models\User;
use App\Services\ArtistServices;
use App\Services\MusicService;

class MusicController extends BaseController
{
    protected $musicService,$artistServices;
    public function __construct(MusicService $musicService, ArtistServices $artistServices)
    {
        $this->musicService = $musicService;
        $this->artistServices = $artistServices;
    }

    public function index(){
        $this->authorize('viewAny', Music::class);

        $music = $this->musicService->getMusics();
        return view('music.list',compact('music'));
    }

    public function create()
    {
        $this->authorize('create', Music::class);

        $genres= $this->musicService->getGenre();
        $artists = $this->artistServices->getArtistsForDropdown();
        return view('music.form',[
                'genres' => $genres,
                'artists' => $artists
        ]);
    }

    public function store(MusicRequest $request)
    {
        $this->authorize('create', Music::class);

        $data = $request->validated();
        $response = $this->musicService->storeMusic($data);
        $response = $response->getData();
        if($response->status === true){
            return to_route('music.index')->with('success', $response->message);
        }
        return back()->withErrors($response->message);

    }

    public function edit(Music $music)
    {
        $this->authorize('create', $music);

        $gender_types = User::GENDERS;
        $artist = $this->musicService->getMusic($music->id);
        $artists = $this->artistServices->getArtistsForDropdown();
        $response = $artist->getData();
        if($response->status === true){
            $artist = $response->data[0];
            return view('music.form',['gender_types' => $gender_types,'artist' => $artist,'artists' => $artists]);
        }
        return back()->withErrors($response->message);
    }

    public function update(MusicRequest $request, Music $music)
    {
        $this->authorize('create', $music);

        $data = $request->validated();
        $response = $this->musicService->updateMusic($data,$music->id);
        $response = $response->getData();

        if($response->status === true){
            return to_route('music.index')->with('success', $response->message);
        }
        return back()->withErrors($response->message);
    }

    public function destroy($music)
    {
        $this->authorize('create', $music);

        $response = $this->musicService->deleteMusic($music->id);
        $response = $response->getData();
        if($response->status === true){
            return to_route('music.index')->with('success',$response->message);
        }
        return back()->withErrors('Music not found!');
    }
}
