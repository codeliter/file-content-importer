<?php
declare(strict_types=1);

namespace App\Http\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Http\Repository
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = app($model);
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
