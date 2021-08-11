<?php
declare(strict_types=1);

namespace Tests\Console\Commands;

use App\Jobs\ImportFileContentJob;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * Class ImportFileContentCommandTest
 * @package Tests\Console\Commands
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class ImportFileContentCommandTest extends TestCase
{
    public function test_command_works()
    {
        $file = tempnam(sys_get_temp_dir(), '');
        file_put_contents($file, json_encode(['hi']));
        $this->artisan("import:file:content $file")
            ->assertExitCode(0);
        Queue::assertPushed(ImportFileContentJob::class);
    }

    public function test_command_mime_type_not_supported()
    {
        $file = tempnam(sys_get_temp_dir(), '');
        $this->artisan("import:file:content $file")
            ->assertExitCode(1);
    }

    public function test_command_file_does_not_exist()
    {
        $this->artisan("import:file:content sksks")
            ->assertExitCode(2);
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Queue::fake();
    }
}
