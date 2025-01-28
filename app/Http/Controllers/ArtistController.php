<?php

namespace App\Http\Controllers;

use App\Export\ArtistExport;
use App\Http\Requests\Artist\ArtistCreateRequest;
use App\Import\ImportArtist;
use App\Models\Artist;
use App\Models\User;
use App\Services\ArtistServices;

class ArtistController extends BaseController
{
    protected $artistService;
    public function __construct(ArtistServices $artistService)
    {
        $this->artistService = $artistService;
    }
    public function importExcel()
    {
        $data = request()->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            $importer = new ImportArtist($data['excel_file'],$this->artistService);
            $importer->import();
            return to_route('artists.index')
                ->with('success', 'Imported successfully');
        }catch (\Exception $e){
            return to_route('artists.index')
                ->with('danger', $e->getMessage());
        }
    }

    public function index(){
        $this->authorize('viewAny',Artist::class);
        if (request('export')) {
            new ArtistExport();
            return to_route('artists.index')
                ->with('success', 'Export successfully');
        }
        $artists = $this->artistService->getArtists();
        return view('artist.list',compact('artists'));
    }

    public function create()
    {
        $this->authorize('create',Artist::class);

        $gender_types = User::GENDERS;
        return view('artist.form',['gender_types' => $gender_types]);
    }

    public function store(ArtistCreateRequest $request)
    {
        $this->authorize('create', Artist::class);

        $data = $request->validated();
        $response = $this->artistService->storeArtist($data);
        $response = $response->getData();
        if($response->status === true){
            return to_route('artists.index')->with('success', $response->message);
        }
        return back()->withErrors($response->message);

    }

    public function edit(Artist $artist)
    {
        $this->authorize('update',$artist);

        $gender_types = User::GENDERS;
        $artist = $this->artistService->getArtist($artist->id);
        $response = $artist->getData();
        if($response->status === true){
            $artist = $response->data[0];
            return view('artist.form',['gender_types' => $gender_types,'artist' => $artist]);
        }
        return back()->withErrors($response->message);
    }

    public function update(ArtistCreateRequest $request, Artist $artist)
    {
        $this->authorize('update', $artist);

        $data = $request->validated();
        $response = $this->artistService->updateArtist($data,$artist->id);
        $response = $response->getData();

        if($response->status === true){
            return to_route('artists.index')->with('success', $response->message);
        }
        return back()->withErrors($response->message);
    }

    public function destroy(Artist $artist)
    {
        $this->authorize('delete', $artist);

        $response = $this->artistService->deleteArtist($artist->id);
        $response = $response->getData();
        if($response->status === true){
            return to_route('artists.index')->with('success',$response->message);
        }
        return back()->withErrors('Artist not found!');
    }

}
