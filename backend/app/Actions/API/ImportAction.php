<?php

namespace App\Actions\API;

use App\Contracts\Actions\ImportActionContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\ExcelServiceContract;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ImportAction implements ImportActionContract
{
    public function __construct(
        public ExcelServiceContract $service,
    ) {}

    public function __invoke(array $data): array
    {
        try {
            $this->service->importUsersByCSV($data);
            return [
                'response' => [
                    'message' => 'Пользователи были успешно добавлены!',
                ],
                'status' => 200
            ];

        } catch (QueryException $exception) {
            Log::error('При импорте что-то пошло не так' . $exception->getMessage());
            return [
                'response' => [
                    'error' => $exception->getMessage(),
                ],
                'status' => 500
            ];
        }
    }
}
