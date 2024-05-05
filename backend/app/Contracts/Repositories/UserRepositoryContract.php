<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryContract
{
    /**
     * @param array $data
     * @return User
     */
    public function store(array $data): User;

    /**
     * @param string $title
     * @return Collection
     */
    public function findByTitle(string $title): Collection;

    /**
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
