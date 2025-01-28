<?php

namespace App\Export;

use App\Services\ExcelExportService;
use Illuminate\Support\Facades\DB;

class ArtistExport extends ExcelExportService
{
    public function getRows($filters): array
    {
        $query = DB::table('artists');

        return $query
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })->toArray();
    }

    public function getHeader(): array
    {
        return [
            'ID','Name','Address','Gender','Date of Birth','First Release Year',
            'No of Albums Released','CreatedAt','UpdatedAt'
        ];
    }

    public function getName(): string
    {
        return 'artists';
    }
}
