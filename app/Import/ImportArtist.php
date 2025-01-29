<?php

namespace App\Import;

use App\Services\ArtistServices;
use App\Services\ExcelImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImportArtist extends ExcelImport
{
    protected ArtistServices $artistServices;

    private const EXPECTED_COLUMNS = [
        'Name',
        'Address',
        'Gender',
        'Date of Birth',
        'First Release Year',
        'No of Albums Released'
    ];
    /**
     * Create a new class instance.
     */
    public function __construct($filePath,ArtistServices $artistServices)
    {
        parent::__construct($filePath);
        $this->artistServices = $artistServices;

        $this->validateColumns(self::EXPECTED_COLUMNS);
    }

    public function formattedData(array $row): array
    {
        return [
            'name' => $row['Name'] ?? null,
            'address' => $row['Address'] ?? null,
            'gender' => $row['Gender'] ?? null,
            'dob' => $row['Date of Birth'] ?? null,
            'first_release_year' => $row['First Release Year'] ?? null,
            'no_of_albums_released' => $row['No of Albums Released'] ?? null,
        ];
    }

    private function validateData($data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'first_release_year' => ['required','numeric','digits:4','after:1900-01-01'],
            'no_of_albums_released' =>['required','numeric'],
            'dob' =>['required','date'],
        ];

        $validator = Validator::make($data,$rules);
        if($validator->fails()){
            return $validator->errors();
        }else{
            return true;
        }
    }
    public function import()
    {
        foreach($this->getRows() as $row)
        {
            DB::beginTransaction();
            try{
                try{
                    $data = $this->formattedData($row);
                    $validated = $this->validateData($data);
                    if($validated === true){
                        $this->artistServices->storeArtist($data);
                    }else{
                        Log::error('Failed to import artists. Validation errors',[
                            'error' => $validated
                        ]);
                    }

                }catch (\Exception $e){
                    Log::error('Error processing row',[
                        'row' => $row,
                        'error' => $e->getMessage()
                    ]);
                }
                DB::commit();
            }catch(\Throwable $e){
                DB::rollBack();

                Log::error('Failed to import artists',[
                    'error' => $e->getMessage()
                ]);
                throw new \RuntimeException('Failed to import artists');
            } finally {
                $this->unLinkFile();
            }
        }

    }
}
