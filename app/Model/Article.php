<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table   = 'article';

    protected $guarded = [];

    public $timestamps = null;

    public function collect()
    {
        return $this->hasOne('App\Model\Collect', 'collect_id', 'id');
    }
}
