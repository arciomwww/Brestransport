<?php

namespace App\Tasks\User;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Tasks\User\DestroyAllTaskContract;

readonly class DestroyAllTask implements DestroyAllTaskContract
{
    public function __construct(
        private UserRepositoryContract $userRepository,
    ) {
    }

    public function run(): void
    {
        $this->userRepository->truncate();
    }
}
