<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table   = 'mark';

    protected $guarded = [];

    public $timestamps = null;

    public function category () {
        return $this->hasOne('App\Model\Category', 'id', 'category_id');
    }
}
