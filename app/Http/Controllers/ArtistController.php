<?php

namespace App\Http\Controllers;

use App\Export\ArtistExport;
use App\Http\Requests\Artist\ArtistCreateRequest;
use App\Http\Requests\Artist\ImportExcelRequest;
use App\Import\ImportArtist;
use App\Jobs\ImportArtistJob;
use App\Models\Artist;
use App\Models\User;
use App\Services\ArtistServices;
use App\Traits\UploadFIle;
use Illuminate\Http\Request;

class ArtistController extends BaseController
{
    use UploadFile;
    protected $artistService;
    public function __construct(ArtistServices $artistService)
    {
        $this->artistService = $artistService;
    }
    public function importExcel(ImportExcelRequest $request)
    {
        try {
            $filePath = $this->storeFile($request->excel_file);

            if($request->by_job){
                ImportArtistJob::dispatch($filePath, $this->artistService);
            }else{
                $importer = new ImportArtist($filePath,$this->artistService);
                $importer->import();
            }

            return to_route('artists.index')->with('success', 'Imported successfully');
        }catch (\Exception $e){
            return back()->with('danger', $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny',Artist::class);

        if (request('export')) {
            new ArtistExport($request);
            return to_route('artists.index')->with('success', 'Export successfully');
        }

        $response = $this->artistService->getArtistsWithPagination($request)->getData();
        if(!$response->status){
            return back()->withErrors($response->message);
        }

        return view('artist.list',[
            'artists' => $response->data->artists,
            'search' => $response->data->search,
            'artistInstance' => Artist::class
        ]);
    }

    public function create()
    {
        $this->authorize('create',Artist::class);
        return view('artist.form',['gender_types' => User::GENDERS]);
    }

    public function store(ArtistCreateRequest $request)
    {
        $this->authorize('create', Artist::class);
        return $this->handelResponse(
            $this->artistService->storeArtist($request->validated()),
            'artists.index'
        );
    }

    public function show($id)
    {
        $this->authorize('viewAny', Artist::class);
        $response = $this->artistService->getArtist($id)->getData();

        return view('artist.show',['artist' => $response->data]);
    }

    public function edit(Artist $artist)
    {
        $this->authorize('update',$artist);
        $response = $this->artistService->getArtist($artist->id)->getData();
        if(!$response->status){
            return back()->withErrors($response->message);
        }

        return view('artist.form',[
            'gender_types' => User::GENDERS,
            'artist' => $response->data
        ]);
    }

    public function update(ArtistCreateRequest $request, Artist $artist)
    {
        $this->authorize('update', $artist);

        return $this->handelResponse(
            $this->artistService->updateArtist($request->validated(),$artist->id),
            'artists.index'
        );
    }

    public function destroy(Artist $artist)
    {
        $this->authorize('delete', $artist);

        return $this->handelResponse(
            $this->artistService->deleteArtist($artist->id),
            'artists.index'
        );
    }

    public function music(Request $request,$id)
    {
        $this->authorize('viewAny',Artist::class);

        $artist = $this->artistService->getArtist($id)->getData();
        $response = $this->artistService->artistMusic($request,$id)->getData();

        if(!$response->status){
            return back()->withErrors($response->message);
        }

        return view('artist.music',[
            'music' => $response->data,
            'artist' => $artist->data
        ]);
    }

}
