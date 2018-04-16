<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Identifier extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'publication_id', 'url_type_id',
    ];

    public function urls() {
        return $this->hasMany(Url::class);
    }

    public function story() {
        return $this->belongsTo(Story::class);
    }

    public function publication() {
        return $this->belongsTo(Publication::class);
    }

    public function urlType() {
        return $this->belongsTo(UrlType::class);
    }
}
