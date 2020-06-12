<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table   = 'article';

    protected $guarded = [];

    public $timestamps = null;
}
