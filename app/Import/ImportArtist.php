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

    protected function getRowsInChunks(int $chunkSize)
    {
        $rows = $this->getRows();
        return array_chunk($rows,$chunkSize);
    }
    public function import()
    {
        if(empty($this->getRows())){
            Log::warning('Uploaded File is empty or has no valid rows');

             activity()->event('Empty data uploaded')
                    ->log('Uploaded File is empty or has no valid rows');
        }

        $failedRows = [];

        foreach($this->getRowsInChunks(5000) as $chunk)
        {
            DB::beginTransaction();
            try{
                foreach($chunk as $index => $row){
                    $data = $this->formattedData($row);
                    $validated = $this->validateData($data);
                    if($validated === true){
                        $this->artistServices->storeArtist($data);
                    }else{
                        $failedRows[] = [
                            'row' => $index + 1,
                            'errors' => $validated
                        ];

                    }
                }

                    DB::commit();

            }catch (\Exception $e){
                    DB::rollBack();

                    Log::error('Error processing row',[
                        'row' => $row,
                        'error' => $e->getMessage()
                    ]);

                    activity()->event('Failed Processing Row')
                    ->log('Failed to process row while chunking : ' . json_encode($row). 'Errors:' . $e->getMessage());
                }
            }

         if(!empty($failedRows)){

            Log::error('Invalid field detected. Please check Excel file',[
                'invalid_fields' => $failedRows,
            ]);

            activity()->event('Invalid Fields')
                    ->withProperties(['invalid_fields' => $failedRows])
                    ->log('Invalid fields detected. Please check excel file.');
        }else{
              activity()->event('Uploaded Data')
                    ->log('Successfully updated data.');
        }
    }
}
