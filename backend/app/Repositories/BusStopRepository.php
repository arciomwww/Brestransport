<?php

namespace App\Repositories;

use App\Contracts\Repositories\BusStopRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\BusStop;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class BusStopRepository extends CoreRepository implements BusStopRepositoryContract
{

    protected function getModelClass(): string
    {
        return BusStop::class;
    }


    public function all(array $select = ['*']): Collection
    {
        return $this->startConditions()
            ->select($select)
            ->get();
    }

    public function store(array $data): BusStop
    {
        return $this->startConditions()
            ->create($data);
    }

    public function getAllForExcel(): Collection
    {
        return $this->startConditions()
            ->join('users', 'users.bus_stop_id', '=', 'bus_stops.id')
            ->select(
                'bus_stops.title',
                'bus_stops.next',
                'users.full_name',
                'users.phone_number',
                'users.email',
                'users.password',
            )
            ->get();
    }

    public function findByTitleAndNext(array $data, array $select = ['*']): BusStop
    {
        return $this->startConditions()
            ->select($select)
            ->where('title', $data['title'])
            ->where('next', $data['next'])
            ->first();
    }
}
