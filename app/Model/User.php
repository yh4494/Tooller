<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table   = 'user';

    protected $guarded = [];

    public $timestamps = null;
}
