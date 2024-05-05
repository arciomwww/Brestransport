<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends CoreRepository implements UserRepositoryContract
{

    protected function getModelClass(): string
    {
        return User::class;
    }

    public function store(array $data): User
    {
        return $this->startConditions()
            ->create($data);
    }

    public function findByTitle(string $title): Collection
    {
        return  $this->startConditions()
            ->select([
                'id',
                'full_name',
                'phone_number',
                'email',
                'password',
            ])
            ->where('title', '=', $title)
            ->get();
    }

    public function delete(int $id): ?bool
    {
        return $this->startConditions()
            ->find($id)
            ?->delete();
    }
}
