<?php

namespace App\Contracts\Actions;

interface DeleteAllUserActionContract
{
    /**
     * @return array
     */
    public function __invoke(): array;
}
