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
    public function __construct($file)
    {
        try {
            $this->filePath = Storage::path($this->storeFile($file));
        }catch (\Exception $e){
            Log::error('Failed to store file', ['error' => $e->getMessage()]);
            throw new \RuntimeException('Fail to store the uploaded file');
        }
    }
    private function storeFile($file): string
    {
        $this->validateFile($file);
        return Storage::putFileAs(
            'temp',$file,'imported.xlsx'
        );
    }
    private function validateFile($file): void
    {
        $allowedExtension = ['xlsx','xls'];
        if(!$file->isValid() && !in_array($file->getClientOriginalExtenstion(),$allowedExtension))
        {
            throw new \InvalidArgumentException('Invalid File. Please upload a valid excel with .xlsx extension');
        }
    }
    public function getRows(): array
    {
        try {
            return SimpleExcelReader::create($this->filePath)
                ->getRows()
                ->toArray();
        }catch(\Exception $e)
        {
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
                throw new \RuntimeException('Invalid columns in the excel file.');
            }

        }catch (\Exception $e){
            Log::error('Column Validation Failed',[
                'error' => $e->getMessage(),
                'expected' => $expectedColumns
            ]);
            throw new \RuntimeException("The excel format is incorrect");
        }
    }

    abstract public function formattedData(array $row): array;

    public function unLinkFile()
    {
        try{
            if(Storage::exists($this->filePath)){
                Storage::delete($this->filePath);
            }
        }
        catch(\Exception $e)
        {
            Log::error('Failed delete temporary file',['error' => $e->getMessage()]);
        }
    }
}
