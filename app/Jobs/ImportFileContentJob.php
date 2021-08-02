<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Helpers\File\JsonFileParser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class ImportFileContentJob
 * @package App\Jobs
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class ImportFileContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $file;

    /**
     * @var string
     */
    private string $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $file, string $type)
    {
        $this->file = $file;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        switch ($this->type) {
            case 'json':
            default:
                $file = new JsonFileParser($this->file);
        }


        $contents = $file->load();
        foreach ($contents as $key => $content) {
            $age = (!is_null($content['date_of_birth']))
                ? Carbon::createFromTimestamp(strtotime($content['date_of_birth']))->diffInYears(now())
                : 18;


            if ($age < 18 or $age > 65) {
                $content['record_key'] = sha1($this->file . $this->type . $key);
                User::with([])->firstOrCreate(['record_key' => $content['record_key']], $content);
            }
        }
    }
}
