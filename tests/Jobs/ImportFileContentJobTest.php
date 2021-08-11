<?php
declare(strict_types=1);

namespace Tests\Jobs;

use App\Jobs\ImportFileContentJob;
use App\Models\Job;
use Tests\TestCase;

/**
 * Class ImportFileContentJobTest
 * @package Tests\Jobs
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class ImportFileContentJobTest extends TestCase
{
    public function testJobIsHandled()
    {
        $file = tempnam(sys_get_temp_dir(), '');
        file_put_contents($file, json_encode(['hi']));
        $this->artisan("import:file:content $file")->execute();
        $job = Job::with([])->first();
        $this->assertEquals(ImportFileContentJob::class, $job->payload['displayName']);
        $this->assertEquals($file, $job->command->getFile());
        $this->assertEquals('json', $job->command->getType());
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }
}