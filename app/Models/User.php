<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'checked',
        'description',
        'interest',
        'date_of_birth',
        'email',
        'account',
        'credit_card',
        'record_key' // To mark record to be inserted as unique
    ];

    protected $casts = [
        'credit_card' => 'array',
        'checked' => 'boolean'
    ];

    protected $hidden = [
        'record_key'
    ];
}
