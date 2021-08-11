<?php
declare(strict_types=1);

namespace Tests\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Models\User;
use Tests\TestCase;

/**
 * Class BaseRepositoryTest
 * @package Tests\Http\Repository
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class BaseRepositoryTest extends TestCase
{
    public function test___construct()
    {
        $base = new class extends BaseRepository {
            public function __construct()
            {
                parent::__construct(User::class);
            }
        };

        $base = new $base;
        $this->assertInstanceOf(User::class, $base->getModel());
    }
}
