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

## Support

Only JSON files are supported for now. <br><br>
You can write a parser for any file format that implements the `App\Helpers\File\StreamFileInterface` and all the method
in the interface.
