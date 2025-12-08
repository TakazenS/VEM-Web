<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'service',
        'name',
        'email',
        'tel',
        'object',
        'corps',
    ];
}
