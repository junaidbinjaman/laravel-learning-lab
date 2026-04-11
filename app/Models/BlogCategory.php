<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name;
 * @property string $slug;
 */
class BlogCategory extends Model
{
    //
    protected $fillable = [
        'name',
        'slug'
    ];
}
