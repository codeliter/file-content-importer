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
     * @var JsonMachine
     */
    private JsonMachine $file;

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = JsonMachine::fromFile($file);
    }

    /**
     * @return iterable
     * @throws Exception
     */
    function load(): iterable
    {
        return $this->file->getIterator();
    }
}
