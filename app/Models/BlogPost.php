<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $user_id
 * @property string $category_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $excerpt
 * @property string $thumbnail
 * @property string $status
 * @property DateTime $published_at
 */
class BlogPost extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'thumbnail',
        'status',
        'published_at'
    ];
}
