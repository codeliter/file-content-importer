<?php
declare(strict_types=1);

namespace App\Helpers\File;

interface StreamFileInterface
{
    static function load(string $file): iterable;
}
