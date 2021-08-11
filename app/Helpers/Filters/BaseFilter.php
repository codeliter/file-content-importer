<?php
declare(strict_types=1);

namespace App\Helpers\Filters;

use App\Helpers\Filters\Exceptions\InvalidFilterRecordsException;
use App\Helpers\Filters\Exceptions\InvalidFilterRuleException;
use App\Helpers\Filters\Exceptions\InvalidFilterRuleRecordException;
use Illuminate\Support\Arr;

/**
 * Class BaseFilter
 * @package App\Helpers\Filters
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
abstract class BaseFilter implements BaseFilterInterface, FilterInterface
{
    /**
     * @var array
     */
    private array $rules;
    /**
     * @var array
     */
    private array $record;

    /**
     * @var array
     */
    private array $validated;


    /**
     * @param array $record
     * @throws InvalidFilterRuleException
     * @throws \Exception
     */
    public function __invoke(array $record)
    {
        // Add the rules
        $this->rules = $this->validateRules($this->rules());
        // Add the record we intend to validate
        $this->record = $record;
        // Validate the Record
        $this->validateRecord();
    }

    /**
     * Make sure the rules are valid
     * @param array $rules
     * @return array
     * @throws InvalidFilterRuleException
     */
    private function validateRules(array $rules): array
    {
        array_walk($rules, function ($rule) {
            if (!$rule instanceof \Closure && !is_callable($rule)) {
                throw new InvalidFilterRuleException();
            }
        });
        return $rules;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @throws \Exception
     */
    private function validateRecord(): void
    {
        if (count($this->record) == 0 && count($this->rules) > 0) {
            throw new InvalidFilterRecordsException();
        }

        if (count($this->record) == 0 && count($this->rules) == 0) {
            $this->validated = [];
            return;
        }

        array_walk($this->rules, function (callable $rule, $key) {
            if (!Arr::has($this->record, $key)) {
                throw new InvalidFilterRuleRecordException('The data doesn\'t contain ' . $key);
            }
            // let's run through the rules
            $this->validated[$key] = call_user_func($rule, Arr::get($this->record, $key));
        });
    }

    /**
     * @return bool
     */
    public function passed(): bool
    {
        $validated = array_filter($this->validated, function ($success) {
            return $success == true;
        });

        // Make sure the successful validations is equal to the number of rules
        return count($validated) === count($this->rules);
    }
}
