<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $email
 * @property "make|female" $gender
 */
class Student extends Model
{
    //

    protected $fillable = ['name', 'email', 'gender'];
}
