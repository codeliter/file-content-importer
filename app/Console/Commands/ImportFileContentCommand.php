<?php

namespace App\Console\Commands;

use App\FileTrait;
use App\Jobs\ImportFileContentJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

/**
 * Class ImportFileContentCommand
 * @package App\Console\Commands
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class ImportFileContentCommand extends Command
{
    use FileTrait;

    const FILE_JSON = 'json';

    const SUPPORTED_FILE_TYPES = [
        'application/json' => self::FILE_JSON,
        'text/plain' => self::FILE_JSON
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:file:content {file : The absolute path to the file}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import file content';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        if (!file_exists($filePath)) {
            $this->error('File does not exist currently');
            return 0;
        }
        // Make sure the file type is supported
        $mime = $this->getMimeType($filePath);
        if (!in_array($mime, array_keys(static::SUPPORTED_FILE_TYPES), true)) {
            $allowed = implode(", ", array_values(static::SUPPORTED_FILE_TYPES));
            $this->error("Only $allowed files can be processed at this time.");
            return 0;
        }

        $this->line('The file has been queued and contents are currently being processed.');
        Queue::push(new ImportFileContentJob($filePath, self::SUPPORTED_FILE_TYPES[$mime]));
        $this->info('File contents imported successfully.');
        return 0;
    }
}
