<?php
declare(strict_types=1);

namespace App\Helpers\Filters;

interface FilterInterface
{
    public function rules(): array;
}
