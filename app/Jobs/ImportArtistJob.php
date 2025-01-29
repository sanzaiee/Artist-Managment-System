<?php

namespace App\Jobs;

use App\Import\ImportArtist;
use App\Services\ArtistServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportArtistJob implements ShouldQueue
{
    use Queueable;

    protected $filePath, $artistService;
    /**
     * Create a new job instance.
     */
    public function __construct($filePath, ArtistServices $artistServices)
    {
        $this->artistService = $artistServices;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $importer = new ImportArtist($this->filePath,$this->artistService);
        $importer->import();
    }
}
