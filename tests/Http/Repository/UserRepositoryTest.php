<?php
declare(strict_types=1);

namespace Tests\Http\Repository;

use App\Helpers\Filters\UserFilters;
use App\Http\Repository\UserRepository;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * Class UserRepositoryTest
 * @package Tests\Http\Repository
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class UserRepositoryTest extends TestCase
{
    public function testFirstOrCreate()
    {
        $user = User::factory()->create();
        (new UserRepository)->firstOrCreate(['id' => $user->id], User::factory()->raw());
        $this->assertDatabaseHas(
            'users',
            [
                'name' => $user->name
            ]
        );
    }

    public function testSaveRecords()
    {
        $iterable = function () use (&$users): iterable {
            return $users = [User::factory()->raw(), User::factory()->raw()];
        };
        (new UserRepository)->saveRecords(
            $iterable(),
            $this->faker->uuid,
            new UserFilters
        );
        array_walk($users, function ($user) {
            $this->assertDatabaseHas('users', [
                'name' => $user['name'],
                'date_of_birth' => $user['date_of_birth']
            ]);
        });
    }

    public function testSaveRecordsFilterIsChecked()
    {
        $iterable = function () use (&$users): iterable {
            return $users = [
                User::factory()->raw(),
                User::factory()->raw([
                    'date_of_birth' => Carbon::now()->subYears(89)->toDateTimeString()
                ])
            ];
        };
        (new UserRepository)->saveRecords(
            $iterable(),
            $this->faker->uuid,
            new UserFilters
        );
        $this->assertDatabaseHas('users', [
            'name' => $users[0]['name'],
            'date_of_birth' => $users[0]['date_of_birth']
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => $users[1]['name'],
            'date_of_birth' => $users[1]['date_of_birth']
        ]);
    }
}
