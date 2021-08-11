<?php
declare(strict_types=1);

namespace App\Providers;

use App\Helpers\File\JsonFileParser;
use App\Helpers\File\StreamFileInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class FileParserProvider
 * @package App\Providers
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class FileParserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StreamFileInterface::class, function ($container, $t) {
            $type = $t['type'] ?? 'json';
            switch ($type) {
                case 'json':
                default:
                    return JsonFileParser::class;
            }
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
