<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'domain', 'phone', 'email', 'GAProfileId', 'logo', 'GAJsonFile'];

    public function actions() {
        return $this->hasMany(Action::Class);
    }

    public function ignoreParams() {
        return $this->hasMany(Action::Class)->where('action_type_id', '=', '1');
    }
}
