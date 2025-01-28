<?php

namespace App\Import;

use App\Services\ArtistServices;
use App\Services\ExcelImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public function __construct($file,ArtistServices $artistServices)
    {
        parent::__construct($file);
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

    public function import()
    {
        foreach($this->getRows() as $row)
        {
            DB::beginTransaction();
            try{
                try{
                    $data = $this->formattedData($row);
                    $this->artistServices->storeArtist($data);

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
