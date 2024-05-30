<?php

namespace App\Contracts\Presenters;

use App\Models\BusStop;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

interface BusStopPresenterContract
{
    public function presentByKeys(Collection $collection, array $keys): Collection;

    public function presentOneByKeys(BusStop $busStop, array $keys): stdClass;
}
