<?php
declare(strict_types=1);

namespace App\Helpers\Filters\Exceptions;

use Throwable;

/**
 * Class InvalidFilterRuleException
 * @package App\Helpers\Filters\Exceptions
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class InvalidFilterRuleException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: "Filter rule must be assigned a closure/callable as value.",
            $code,
            $previous
        );
    }
}
