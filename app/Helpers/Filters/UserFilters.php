<?php
declare(strict_types=1);

namespace App\Helpers\Filters;

use Carbon\Carbon;

/**
 * Class UserFilters
 * @package App\Helpers\Filters
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class UserFilters extends BaseFilter
{
    /**
     * @return bool[]
     */
    public function rules(): array
    {
        // These are the rules
        // Each key maps to a valid key in the array of record to be filtered
        // and the value must be a closure that returns a boolean
        return [
            'date_of_birth' => [$this, 'validateAge'],
            'credit_card.number' => function ($value): bool {
                return true;
                // You can uncomment this line to enable the credit_card check
                // return $this->validateCreditCard($value);
            },
        ];
    }

    /**
     * @param string|null $date_of_birth
     * @return bool
     */
    public function validateAge(?string $date_of_birth = null): bool
    {
        $age = (!is_null($date_of_birth))
            ? Carbon::createFromTimestamp(strtotime($date_of_birth))->diffInYears(now())
            : 18;


        if ($age < 18 or $age > 65) {
            return false;
        }

        return true;
    }

    /**
     * @param string $number
     * @return bool
     */
    public function validateCreditCard(string $number): bool
    {
        // Validate the number has 3 identical numbers in sequence
        $numbers = [];
        $last = null;
        for ($i = 0; $i < strlen($number); $i++) {
            // If the last number is equal the current number
            if ($last === $number[$i]) {
                $numbers[$last] += 1;
            } else {
                $numbers[$number[$i]] = 1;
            }
            $last = $number[$i];
        }

        return count(
                array_filter($numbers, function ($number) {
                    return $number == 3;
                })
            ) > 0;
    }

}
