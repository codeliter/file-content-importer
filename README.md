# Import File Content

Import file content and store in database

## Installation

Run

```
composer install
```

## Usage

```
php artisan import:file:content {FILE_TO_BE_IMPORTED}
```

`{FILE_TO_BE_IMPORTED}` - Must be replaced with the absolute or relative part of the file to be imported

## Filters

Custom filters can be added for filtering data before they are inserted into the database.

- This can be achieved by extending the <b>App\Helpers\Filters\BaseFilter</b> class.
- You must declare a *rules* method that returns an array in your custom filter class.
- The array returned by the *rules* method must be a key of string, and each value must be a *Closure/callable.* that
  returns boolean.
- The array key for the rules support dot notation for support for deeply nested array.
  ```
        $array = [
            'name'=>'steve',
            'data'=>[
               'reg_date'=>'10/09/2021'
            ]
        ];
  ```
  We can define a rule for this array like this:
  ```
    public function rules(): array {
        return [
            'data.reg_date'=>function():bool {return true;}
        ]
    }
  ```
- A filter throw the following exception:
    - `InvalidFilterRuleException`: A Filter rule key must be assigned a closure/callable as value.
    - `InvalidFilterRecordsException`: You must invoke the filter with an array containing values to be validated.
    - `InvalidFilterRuleRecordException`: You are trying to filter a key that doesn't exist in the data passed to the
      filter call.

## Support

Only JSON files are supported for now. <br><br>

You can add support for a new file type by:

- Write a class that implements `App\Helpers\File\StreamFileInterface` and all the method in the interface

- Register the class in the register method of the `App\Providers\FileParserProvider`

- You can always retrieve an instance of the new parser
   ``` 
     $fileParser = $app(StreamFileInterface::class, ['type' => 'json'])
   ```
  The value of the type must be the type you specified while registering the new File Parser.

## Testing

```

php artisan test

```
