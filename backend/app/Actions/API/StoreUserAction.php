<?php

namespace App\Actions\API;

use App\Contracts\Actions\StoreUserActionContract;
use App\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Support\Facades\Log;

readonly class StoreUserAction implements StoreUserActionContract
{
    public function __construct(
        public UserRepositoryContract $userRepository,
    ) {
    }

    public function __invoke(array $data): array
    {
        try {
            $this->userRepository->store($data);
            return [
                'response' => [
                    'message' => 'Пользователь был успешно добавлен!',
                ],
                'status' => 200
            ];

        } catch (\Exception $exception) {
            Log::error('При сохранении что-то пошло не так' . $exception->getMessage());
            return [
                'response' => [
                    'error' => 'Что-то пошло не так',
                ],
                'status' => 500
            ];
        }
    }
}
