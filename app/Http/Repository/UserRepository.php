<?php
declare(strict_types=1);

namespace App\Http\Repository;

use App\Helpers\Filters\BaseFilterInterface;
use App\Http\Repository\Interfaces\EloquentWriteInterface;
use App\Models\User;
use Exception;

/**
 * Class UserRepository
 * @package App\Http\Repository
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class UserRepository extends BaseRepository implements EloquentWriteInterface
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @param iterable $contents
     * @param string $keyPrefix
     * @param BaseFilterInterface $filter
     * @throws Exception
     */
    public function saveRecords(iterable $contents, string $keyPrefix, BaseFilterInterface $filter)
    {
        foreach ($contents as $key => $content) {
            // Validate the record
            $filter($content);
            // If filter validation passed
            if (!$filter->passed()) {
                continue;
            }
            $content['record_key'] = sha1($keyPrefix . $key);
            $this->firstOrCreate(['record_key' => $content['record_key']], $content);
        }
    }

    /**
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public function firstOrCreate(array $where, array $data)
    {
        return $this->model::with([])->firstOrCreate($where, $data);
    }
}
