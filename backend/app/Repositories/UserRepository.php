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

    public function findByStop(int $id): Collection
    {
        return $this->startConditions()
            ->select([
                'id',
                'full_name',
                'phone_number',
                'email',
                'password',
            ])
            ->where('bus_stop_id', '=', $id)
            ->get();
    }

    public function delete(int $id): ?bool
    {
        return $this->startConditions()
            ->find($id)
            ?->delete();
    }

    public function insert(array $data): bool
    {
        return $this->startConditions()
            ->insert($data);
    }

    public function getAllForExcel(): Collection
    {
        return $this->startConditions()
            ->join('bus_stops', 'users.bus_stop_id', '=', 'bus_stops.id')
            ->select([
                'bus_stops.title',
                'bus_stops.next',
                'users.full_name',
                'users.phone_number',
                'users.email',
                'users.password',
            ])->get();
    }

    public function truncate(): void
    {
        $this->startConditions()
            ->truncate();
    }
}
