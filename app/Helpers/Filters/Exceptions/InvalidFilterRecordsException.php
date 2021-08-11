<?php
declare(strict_types=1);

namespace App\Helpers\Filters\Exceptions;

use Throwable;

/**
 * Class InvalidFilterRecordsException
 * @package App\Helpers\Filters\Exceptions
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class InvalidFilterRecordsException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: "You must invoke the filter with an array containing our values",
            $code,
            $previous
        );
    }
}
