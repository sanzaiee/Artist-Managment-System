<?php

namespace App\Export;

use App\Services\ExcelExportService;
use Illuminate\Support\Facades\DB;

class ArtistExport extends ExcelExportService
{
    public function getRows($filters): array
    {
        $query = DB::table('artists');

        if(!empty($filters->query('search'))){
            $query->where('name','like','%'. $filters->query('search') .'%');
        }

        if(!empty($filters->query('page'))) {
            $page = (int)$filters->query('page');
            $perPage = (int)$filters->query('perPage',5);

            $offset = ($page - 1) * $perPage;
            $query->skip($offset)->take($perPage);
        }
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
