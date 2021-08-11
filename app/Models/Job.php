<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 * @package App\Models
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class Job extends Model
{
    protected ?object $unserializedCommand = null;

    protected $casts = [
        'payload' => 'json'
    ];


    /**
     * @return array|mixed
     */
    public function getCommandAttribute()
    {
        if (!$this->unserializedCommand) {
            $this->unserializedCommand = unserialize($this->payload['data']['command']);
        }

        return $this->unserializedCommand;
    }
}
