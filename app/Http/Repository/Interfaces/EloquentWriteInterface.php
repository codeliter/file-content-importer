<?php
declare(strict_types=1);

namespace App\Http\Repository\Interfaces;

interface EloquentWriteInterface
{
    public function firstOrCreate(array $where, array $data);
}
