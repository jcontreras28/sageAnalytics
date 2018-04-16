<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlType extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function urls() {
        return $this->hasMany(Url::Class);
    }
}
