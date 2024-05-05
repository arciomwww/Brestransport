<?php

namespace App\Contracts\Actions;

interface StoreUserActionContract
{
    public function __invoke(array $data): array;
}
