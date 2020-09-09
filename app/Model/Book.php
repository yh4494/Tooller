<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table   = 'books';

    protected $guarded = [];

    public $timestamps = null;
}
