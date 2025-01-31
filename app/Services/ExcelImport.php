<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

abstract class ExcelImport
{
    protected string $filePath;
    /**
     * Create a new class instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function getRows(): array
    {
        try {
            return SimpleExcelReader::create($this->filePath)
                ->getRows()
                ->toArray();
        }catch(\Exception $e)
        {
            activity()->event('Failed to read rows')
                    ->withProperties(['error' =>  $e->getMessage()])
                    ->log('Failed to read rows from Excel file');

            Log::error('Failed to read rows from Excel file',['error' => $e->getMessage()]);
            throw new \RuntimeException(('Failed to read rows from the uploaded file'));
        }
    }

    public function getHeaders(): array
    {
        try {
            return SimpleExcelReader::create($this->filePath)
                ->getHeaders();
        }catch(\Exception $e)
        {
            activity()->event('Failed to read header')
                    ->withProperties(['error' =>  $e->getMessage()])
                    ->log('Failed to read header from Excel file');

            Log::error('Failed to read header from Excel file',['error' => $e->getMessage()]);
            throw new \RuntimeException(('Failed to read header from the uploaded file'));
        }

    }

    protected function validateColumns(array $expectedColumns): void
    {
        try {
            $missingColumns = array_diff($expectedColumns, $this->getHeaders());
            $extraColumns = array_diff($expectedColumns, $this->getHeaders());

            if(!empty($missingColumns) || !empty($extraColumns)){
                activity()->event('Invalid columns in the excel file')
                    ->withProperties(['expected_columns' => $expectedColumns,'missing_columns' =>  $missingColumns])
                    ->log('Column Validation Failed');
                throw new \RuntimeException('Invalid columns in the excel file.');
            }

        }catch (\Exception $e){
            activity()->event('Column Validation Failed')
                ->withProperties(['expected_columns' => $expectedColumns,'error' =>  $e->getMessage()])
                ->log('Column Validation Failed');

            Log::error('Column Validation Failed',[
                'error' => $e->getMessage(),
                'expected' => $expectedColumns
            ]);
            throw new \RuntimeException("The excel format is incorrect");
        }
    }

    abstract public function formattedData(array $row): array;

}
