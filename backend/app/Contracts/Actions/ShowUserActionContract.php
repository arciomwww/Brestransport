<?php

namespace App\Contracts\Actions;

interface ShowUserActionContract
{
    public function __invoke(array $data): array;
}
