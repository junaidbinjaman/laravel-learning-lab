<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $status
 */
class Comment extends Model
{
    //
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'status'
    ];
}
