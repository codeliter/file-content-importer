<?php
declare(strict_types=1);

namespace App\Helpers\File;

use Exception;
use JsonMachine\JsonMachine;

/**
 * Class JsonFileParser
 * @package App\Helpers\File
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class JsonFileParser implements StreamFileInterface
{
    /**
     * @param string $file
     * @return iterable
     * @throws Exception
     */
    static function load(string $file): iterable
    {
        return JsonMachine::fromFile($file)->getIterator();
    }
}
