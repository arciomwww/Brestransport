<?php

namespace App\Actions\API;

use App\Contracts\Actions\ShowUserActionContract;
use App\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Support\Facades\Log;

class ShowUserAction implements ShowUserActionContract
{
    public function __construct(
        public UserRepositoryContract $userRepository,
    )
    {
    }

    public function __invoke(array $data): array
    {
        try {
            $users = $this->userRepository->findByStop($data['id']);
            return [
                'response' => [
                    'users' => $users
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
