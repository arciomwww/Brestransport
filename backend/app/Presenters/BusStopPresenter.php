<?php

namespace App\Presenters;

use App\Contracts\Presenters\BusStopPresenterContract;
use App\Models\BusStop;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class BusStopPresenter implements BusStopPresenterContract
{
    public function presentByKeys(Collection $collection, array $keys): Collection
    {
        return $collection->transform(function ($item) use ($keys) {
            $newItem = new \stdClass();
            foreach ($keys as $key) {
                $newItem->$key = $item->$key;
            }
            return $newItem;
        });
    }

    public function presentOneByKeys(BusStop $busStop, array $keys): stdClass
    {
        $newBusStop = new stdClass();
        foreach ($keys as $key) {
            $newBusStop->$key = $busStop->$key;
        }
        return $newBusStop;
    }
}
