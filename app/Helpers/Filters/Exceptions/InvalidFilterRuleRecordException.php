<?php
declare(strict_types=1);

namespace App\Helpers\Filters\Exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidFilterRuleRecordException
 * @package App\Helpers\Filters\Exceptions
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class InvalidFilterRuleRecordException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: "The data doesn\'t contain a key", $code, $previous);
    }
}
