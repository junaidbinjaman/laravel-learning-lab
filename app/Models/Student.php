<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property $email
 * @property $gender
 */
class Student extends Model
{
    protected $fillable = ['name', 'email', 'gender'];
}
