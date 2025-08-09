<?php

namespace App\Core\Repositories\Contracts;

interface SettingRepositoryInterface
{
    public function findByKey(string $key): string;

    public function updateByKey(string $key, $value): bool;
}
