<?php

namespace App\Services;

use Spatie\SimpleExcel\SimpleExcelWriter;

abstract class ExcelExportService
{
    public string $extension = '.xlsx';

    abstract public function getRows($filters): array;

    public function __construct($filters = [])
    {
        $writer = SimpleExcelWriter::streamDownload($this->getName().$this->extension);

        if (count($this->getHeader())) {
            $writer->addHeader($this->getHeader());
        }

        $writer->addRows($this->getRows($filters));
        $writer->toBrowser();
    }

    public function getName(): string
    {
        return time();
    }

    public function getHeader(): array
    {
        return [];
    }
}
