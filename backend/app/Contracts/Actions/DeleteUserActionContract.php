<?php

namespace App\Contracts\Actions;

interface DeleteUserActionContract
{
    /**
     * @param int $id
     * @return array
     */
    public function __invoke(int $id): array;
}
