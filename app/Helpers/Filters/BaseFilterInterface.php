<?php
declare(strict_types=1);

namespace App\Helpers\Filters;

interface BaseFilterInterface
{
    public function __invoke(array $record);

    public function passed(): bool;
}
