<?php

namespace App\Actions\API;

use App\Contracts\Actions\DeleteUserActionContract;
use App\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Support\Facades\Log;

class DeleteUserAction implements DeleteUserActionContract
{
    public function __construct(
        public UserRepositoryContract $userRepository,
    )
    {
    }

    public function __invoke(int $id): array
    {
        try {
            if ($this->userRepository->delete($id)) {
                return [
                    'response' => [
                        'message' => 'Пользователь был успешно удалён!',
                    ],
                    'status' => 200
                ];
            } else {
                return [
                    'response' => [
                        'error' => 'Не удалось удалить пользователя',
                    ],
                    'status' => 500
                ];
            }

        } catch (\Exception $exception) {
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
