<?php

namespace App\Actions\API;

use App\Contracts\Actions\DeleteAllUserActionContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Tasks\User\DestroyAllTaskContract;
use Exception;
use Illuminate\Support\Facades\Log;

readonly class DeleteAllUserAction implements DeleteAllUserActionContract
{
    public function __construct(
        public DestroyAllTaskContract $destroyAllTasks,
    ) {
    }

    public function __invoke(): array
    {
        try {
            $this->destroyAllTasks->run();
            return [
                'response' => [
                    'message' => 'Пользователи был успешно удалены!',
                ],
                'status' => 200
            ];

        } catch (Exception $exception) {
            Log::error('При удалении что-то пошло не так' . $exception->getMessage());
            return [
                'response' => [
                    'error' => 'Что-то пошло не так',
                ],
                'status' => 500
            ];
        }
    }
}
