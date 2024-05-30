<?php

namespace App\Presenters;

use App\Contracts\Presenters\UserPresenterContract;
use Illuminate\Database\Eloquent\Collection;

class UserPresenter implements UserPresenterContract
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
}
