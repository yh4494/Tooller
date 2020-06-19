<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table   = 'process';

    protected $guarded = [];

    public $timestamps = null;

    public function article () {
        return $this->hasOne('App\Model\Article', 'process_id', 'id');
    }

    public function childProcess () {
        return $this->hasMany('App\Model\Process', 'pid', 'id');
    }
}
