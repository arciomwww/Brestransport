<?php

namespace App\Contracts\Repositories;

use App\Models\BusStop;
use Illuminate\Database\Eloquent\Collection;

interface BusStopRepositoryContract
{
    /**
     * @param string[] $select
     * @return Collection<int, BusStop>
     */
    public function all(array $select = ['*']): Collection;

    /**
     * @param array $data
     * @return BusStop
     */
    public function store(array $data): BusStop;

    /**
     * @return Collection<int, BusStop>
     */
    public function getAllForExcel(): Collection;

    /**
     * @param array{
     *     title: string,
     *     next: string,
     * } $data
     * @param string[] $select
     * @return BusStop
     */
    public function findByTitleAndNext(array $data, array $select = ['*']): BusStop;
}
