<?php
declare(strict_types=1);

namespace App\Helpers\File;

interface StreamFileInterface
{
    public function __construct(string $file);

    function load(): iterable;
}
