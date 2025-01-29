<?php

namespace App\Http\Controllers;

use App\Http\Requests\Music\MusicRequest;
use App\Models\Music;
use App\Models\User;
use App\Services\ArtistServices;
use App\Services\MusicService;
use Illuminate\Http\Request;

class MusicController extends BaseController
{
    protected $musicService,$artistServices;
    public function __construct(MusicService $musicService, ArtistServices $artistServices)
    {
        $this->musicService = $musicService;
        $this->artistServices = $artistServices;
    }

    public function index(Request $request){
        $this->authorize('viewAny', Music::class);

        $response = $this->musicService->getMusicsWithPagination($request)->getData();
        if(!$response->status){
            return back()->withErrors($response->message);
        }

        return view('music.list',[
            'music' => $response->data->music,
            'search' => $response->data->search,
            'musicInstance' => Music::class
        ]);
    }

    public function create()
    {
        $this->authorize('create', Music::class);

        $artists = $this->artistServices->getArtistsForDropdown()->getData();
        $genres= $this->musicService->getGenre()->getData();

        return view('music.form',[
            'genres' => $genres->data,
            'artists' => $artists->data
        ]);
    }

    public function store(MusicRequest $request)
    {
        $this->authorize('create', Music::class);

        return $this->handelResponse(
            $this->musicService->storeMusic($request->validated()),
            'music.index'
        );
    }

    public function show(Music $music)
    {
        $this->authorize('viewAny', $music);

        $response = $this->musicService->getMusic($music->id)->getData();
        return view('music.show',[
            'music' => $response->data,
        ]);

    }

    public function edit(Music $music)
    {
        $this->authorize('create', $music);

        $response = $this->musicService->getMusic($music->id)->getData();
        if(!$response->status){
            return back()->withErrors($response->message);
        }

        $gender_types = User::GENDERS;
        $artists = $this->artistServices->getArtistsForDropdown()->getData();
        $genres= $this->musicService->getGenre()->getData();

        return view('music.form',[
            'music' => $response->data,
            'artists' => $artists->data,
            'gender_types' => $gender_types,
            'genres' => $genres->data
        ]);
    }

    public function update(MusicRequest $request, Music $music)
    {
        $this->authorize('create', $music);

        return $this->handelResponse(
            $this->musicService->updateMusic($request->validated(),$music->id),
            'music.index'
        );
    }

    public function destroy(Music $music)
    {
        $this->authorize('create', $music);

        return $this->handelResponse(
            $this->musicService->deleteMusic($music->id),
            'music.index'
        );
    }
}
