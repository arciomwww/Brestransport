<?php

namespace App\Contracts\Actions;

interface ImportActionContract
{
    public function __invoke(array $data): array;
}
