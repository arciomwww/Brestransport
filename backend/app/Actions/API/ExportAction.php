<?php

namespace App\Actions\API;

use App\Contracts\Actions\ExportActionContract;
use App\Contracts\Services\ExcelServiceContract;
use Illuminate\Support\Facades\Log;
use League\Csv\CannotInsertRecord;

readonly class ExportAction implements ExportActionContract
{
    public function __construct(
        public ExcelServiceContract $service,
    ) {
    }

    public function __invoke(): array
    {
        try {
            $csv = $this->service->exportUsersByCSV();
            return [
                'content' => $csv->toString(),
                'status' => 200,
                'headers' => [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="users.csv"',
                ],
            ];

        } catch (CannotInsertRecord $exception) {
            Log::error('При экспорте что-то пошло не так' . $exception->getMessage());
            return [
                'response' => [
                    'error' => $exception->getMessage(),
                ],
                'status' => 500,
                'headers' => []
            ];
        }
    }
}
