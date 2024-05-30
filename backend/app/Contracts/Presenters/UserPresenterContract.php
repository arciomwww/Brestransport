<?php

namespace App\Contracts\Presenters;

use App\Models\BusStop;
use Illuminate\Database\Eloquent\Collection;

interface UserPresenterContract
{
    public function presentByKeys(Collection $collection, array $keys): Collection;
}
