<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Console\Commands\ImportFileContentCommand;
use App\Helpers\File\StreamFileInterface;
use App\Helpers\Filters\UserFilters;
use App\Http\Repository\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Spatie\SignalAwareCommand\Events\SignalReceived;
use Spatie\SignalAwareCommand\Signals;

/**
 * Class ImportFileContentJob
 * @package App\Jobs
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class ImportFileContentJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public int $uniqueFor = 30;
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
    public function handle(UserRepository $userRepository)
    {
        $this->listenToSignals();

        $contents = app(StreamFileInterface::class, ['type' => $this->type])::load($this->file);
        $userRepository->saveRecords(
            $contents,
            $this->file . $this->type,
            new UserFilters
        );
    }

    private function listenToSignals()
    {
        Event::listen(function (SignalReceived $event) {
            $signalNumber = $event->signal;

            if (!in_array($signalNumber, ImportFileContentCommand::getHandlesSignals())) {
                return;
            }
            $signalName = Signals::getSignalName($signalNumber);
            $this->fail(new \Exception("Received the {$signalName} signal"));
            $event->command->error("Received the {$signalName} signal. Background job was stopped");
            exit;
        });
    }

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId(): string
    {
        return sha1_file($this->file);
    }

    /**
     * @return mixed
     */
    public function uniqueVia()
    {
        return Cache::driver('file');
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
