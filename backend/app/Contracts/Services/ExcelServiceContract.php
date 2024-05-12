<?php

namespace App\Contracts\Services;

use League\Csv\Writer;

interface ExcelServiceContract
{
    public function importUsersByCSV(array $data): void;
    public function exportUsersByCSV(): Writer;
}
