<?php

namespace App\Jobs;

use App\Import\ImportArtist;
use App\Models\ImportJob;
use App\Models\User;
use App\Notifications\ImportJobStatusNotification;
use App\Services\ArtistServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

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
        try {
            $importer = new ImportArtist($this->filePath,$this->artistService);
            $importer->import();

        } catch (\Exception $e) {
            Log::error('Error processing import job' .$e->getMessage());
        }
    }

     public function failed(\Exception $e)
    {
        activity()
        ->event('Job Failed')
        ->withProperties(['error' => $e->getMessage()])
        ->log('Import data processing job failed');
    }
}
